<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Command;

use Contao\CoreBundle\Command\AbstractLockedCommand;
use Contao\Database;
use Contao\NewsArchiveModel;
use Contao\NewsModel;
use Contao\PageModel;
use Contao\StringUtil;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MigrationCommand extends AbstractLockedCommand
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var bool
     */
    protected $dryRun = false;

    protected $migrations = ['module', 'database', 'both', 'none'];

    public function migratePageOptions(SymfonyStyle $io)
    {
        $io->section('Migrate page settings');

        $io->text('Migrate root page templates');

        $io->note('Only default templates will be migrated.');

        $pages = PageModel::findPublishedRootPages();

        if (!$pages) {
            $io->error('Found no published root pages.');

            return 1;
        }

        if ($io->isVerbose()) {
            $io->text('Found <fg=yellow>'.$pages->count().'</> published root pages.');
        }

        $io->progressStart($pages->count());

        foreach ($pages as $page) {
            $io->progressAdvance();

            if ('youtube_default' == $page->youtube_default) {
                $page->youtube_default = '';
            }

            if ('youtubeprivacy_default' === $page->youtubePrivacyTemplate) {
                $page->youtubePrivacyTemplate = '';
            }

            if (!$this->dryRun) {
                $page->save();
            }
        }
        $io->progressFinish();

        $io->text('<fg=green>Finished page option migration.</>');
    }

    public function migrateNewsReleatedVideos(SymfonyStyle $io)
    {
        $io->section('Migrate tl_news.relatedYoutubeNews data');

        $newsArchives = NewsArchiveModel::findAll();

        if (!$newsArchives) {
            $io->error('Found no news archives.');

            return 1;
        }

        $progressBar = $io->createProgressBar();
        $progressBar->setFormat(" %message%\n\n %current%/%max% [%bar%] %percent:3s%%");

        $emptyArchivesMessages = [];

        foreach ($newsArchives as $key => $newsArchive) {
            $news = NewsModel::findByPid($newsArchive->id);

            if (!$news) {
                $emptyArchivesMessages[] = 'No news for archive '.$newsArchive->title.' (ID: '.$newsArchive->id.')';

                continue;
            }

            $progressBar->setMessage('Migrating news archive '.($key + 1).' / '.$newsArchives->count().' ('.$newsArchive->title.')');
            $progressBar->start($news->count());

            foreach ($news as $entry) {
                $progressBar->advance();

                $relatedVideo = StringUtil::deserialize($entry->relatedYoutubeNews, true)[0];

                if (empty($relatedVideo)) {
                    continue;
                }
                $entry->relatedYoutubeNews = $relatedVideo;

                if (!$this->dryRun) {
                    $entry->save();
                }
            }
        }
        $progressBar->finish();
        $io->newLine(2);

        $io->note($emptyArchivesMessages);

        $io->text('<fg=green>Finished migration relatedYoutubeNews.</>');
    }

    public function migrateDatabase(SymfonyStyle $io)
    {
        $io->section('Migrate database');

        $db = Database::getInstance();

        $io->text('Migrate tl_news.relatedYoutubeNews');

        if ($io->isVerbose()) {
            $io->newLine();
            $io->text('Create relatedYoutubeNews_tmp table');
        }

        if (!$this->dryRun) {
            $res = $db->execute("ALTER TABLE tl_news ADD COLUMN `relatedYoutubeNews_tmp` VARCHAR(32) DEFAULT '' NOT NULL");
        }

        if ($io->isVerbose()) {
            $io->text('Fill temporary table field with values');
        }

        if (!$this->dryRun) {
            $res = $db->execute('UPDATE tl_news SET `relatedYoutubeNews_tmp` = CAST(`relatedYoutubeNews` AS CHAR ) WHERE `relatedYoutubeNews` IS NOT NULL');
        }

        if ($io->isVerbose()) {
            $io->text('Delete old field');
        }

        if (!$this->dryRun) {
            $res = $db->execute('ALTER TABLE tl_news DROP COLUMN `relatedYoutubeNews`');
        }

        if ($io->isVerbose()) {
            $io->text('Rename temporary field to original field');
        }

        if (!$this->dryRun) {
            $res = $db->execute("ALTER TABLE tl_news CHANGE COLUMN `relatedYoutubeNews_tmp` `relatedYoutubeNews` VARCHAR(32) DEFAULT '' NOT NULL");
        }

        $io->newLine();
        $io->text('<fg=green>Finished migrating relatedYoutubeNews field.</>');
    }

    protected function configure()
    {
        $this->setName('huh:youtube:migration')
            ->setDescription('Migration from Youtube Module to Youtube Bundle.')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Performs a run without writing to database.')
            ->addOption('migration', null, InputOption::VALUE_REQUIRED, 'Do migration directly without interrupt. Options: '.implode(', ', $this->migrations))
            ->setHelp("This command provide migration scripts to migrate from heimrichhannot/contao-youtube to heimrichhannot/contao-youtube-bundle.\n\n"
                    ."Available migrations:\n"
                    ."  'module' updates default template names and field values\n"
                    ."  'database' updates database fields that can't be updated by the contao install tool.\n"
                    ."  'both' will run 'module' and 'database' migrations.")
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function executeLocked(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Contao Youtube Bundle migration');

        if ($input->hasOption('dry-run') && $input->getOption('dry-run')) {
            $this->dryRun = true;
            $io->note('Dry run enabled, no data will be changed.');
            $io->newLine();
        }
        $this->getContainer()->get('contao.framework')->initialize();
        $this->output = $output;

        if ($input->hasOption('migration') && null !== $input->getOption('migration')) {
            $migration = $input->getOption('migration');
        } else {
            $migration = $io->choice("Which migration you want to run?\n  'module' updates default template names and field values\n  'database' updates database fields that can't be updated by the contao install tool. \n  'both' will run 'module' and 'database' migrations.", $this->migrations, 'none');
        }

        if (\in_array($migration, ['module', 'both'])) {
            $this->migrateNewsReleatedVideos($io);
            $this->migratePageOptions($io);
        }

        if (\in_array($migration, ['database', 'both'])) {
            $this->migrateDatabase($io);
        }

        $io->success('Youtube Migration finished.');
    }
}

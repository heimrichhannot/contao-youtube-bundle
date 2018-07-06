<?php
if (\Contao\System::getContainer()->get('huh.utils.container')->isBundleActive('HeimrichHannot\ReaderBundle\HeimrichHannotContaoReaderBundle'))
{
    $table = 'tl_reader_config_element';
    \Contao\Controller::loadDataContainer($table);
    $dca = &$GLOBALS['TL_DCA'][$table];

    $dca['palettes'][\HeimrichHannot\YoutubeBundle\ConfigElementType\YoutubeReaderConfigElementType::TYPE] =
        '{title_type_legend},title,type;{config_legend},typeSelectorField,typeField;';
}
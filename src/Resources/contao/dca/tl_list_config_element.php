<?php
if (\Contao\System::getContainer()->get('huh.utils.container')->isBundleActive('HeimrichHannot\ListBundle\HeimrichHannotContaoListBundle'))
{
    $table = 'tl_list_config_element';
    \Contao\Controller::loadDataContainer($table);
    $dca = &$GLOBALS['TL_DCA'][$table];
    
    $dca['palettes'][\HeimrichHannot\YoutubeBundle\ConfigElementType\YouTubeListConfigElementType::TYPE] =
        '{title_type_legend},title,type;{config_legend},youtubeSelectorField,youtubeField;';
    
    $dca['fields']['youtubeSelectorField']     = [
        'label'            => &$GLOBALS['TL_LANG']['tl_list_config_element']['youtubeSelectorField'],
        'inputType'        => 'select',
        'options_callback' => function (DataContainer $dc) {
            return \HeimrichHannot\ListBundle\Util\ListConfigElementHelper::getCheckboxFields($dc);
        },
        'exclude'          => true,
        'eval'             => ['includeBlankOption' => true, 'tl_class' => 'w50 autoheight'],
        'sql'              => "varchar(64) NOT NULL default ''",
    ];
    
    $dca['fields']['youtubeField'] = [
        'label'            => &$GLOBALS['TL_LANG']['tl_list_config_element']['youtubeField'],
        'inputType'        => 'select',
        'options_callback' => function (DataContainer $dc) {
            return \HeimrichHannot\ListBundle\Util\ListConfigElementHelper::getFields($dc);
        },
        'exclude'          => true,
        'eval'             => ['includeBlankOption' => true, 'mandatory' => true, 'chosen' => true, 'tl_class' => 'w50 autoheight'],
        'sql'              => "varchar(64) NOT NULL default ''",
    ];
}
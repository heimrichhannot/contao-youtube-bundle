<?php
if (\Contao\System::getContainer()->get('huh.utils.container')->isBundleActive('HeimrichHannot\ReaderBundle\HeimrichHannotContaoReaderBundle')) {
    $table = 'tl_reader_config_element';
    \Contao\Controller::loadDataContainer($table);
    $dca = &$GLOBALS['TL_DCA'][$table];
    
    $dca['palettes'][\HeimrichHannot\YoutubeBundle\ConfigElementType\YoutubeReaderConfigElementType::TYPE] =
        '{title_type_legend},title,type;{config_legend},youtubeSelectorField,youtubeField,autoplay;';
    
    $fields = [
        'autoplay' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_module']['autoplay'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'w50 m12'],
            'sql'       => "char(1) NOT NULL default ''"
        ],
        'youtubeSelectorField'     => [
            'label'            => &$GLOBALS['TL_LANG']['tl_reader_config_element']['youtubeSelectorField'],
            'inputType'        => 'select',
            'options_callback' => function (DataContainer $dc) {
                return System::getContainer()->get('huh.reader.util.reader-config-element-util')->getCheckboxFields($dc);
            },
            'exclude'          => true,
            'eval'             => ['includeBlankOption' => true, 'tl_class' => 'w50 autoheight'],
            'sql'              => "varchar(64) NOT NULL default ''",
        ],
        'youtubeField'             => [
            'label'            => &$GLOBALS['TL_LANG']['tl_reader_config_element']['youtubeField'],
            'inputType'        => 'select',
            'options_callback' => function (DataContainer $dc) {
                return System::getContainer()->get('huh.reader.util.reader-config-element-util')->getFields($dc);
            },
            'exclude'          => true,
            'eval'             => ['includeBlankOption' => true, 'mandatory' => true, 'chosen' => true, 'tl_class' => 'w50 autoheight'],
            'sql'              => "varchar(64) NOT NULL default ''",
        ],
    ];
    
    $dca['fields'] = array_merge($dca['fields'],$fields);
}
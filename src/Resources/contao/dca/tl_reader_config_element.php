<?php
if (\Contao\System::getContainer()->get('huh.utils.container')->isBundleActive('HeimrichHannot\ReaderBundle\HeimrichHannotContaoReaderBundle')) {
    $table = 'tl_reader_config_element';
    \Contao\Controller::loadDataContainer($table);
    $dca = &$GLOBALS['TL_DCA'][$table];
    
    $dca['palettes'][\HeimrichHannot\YoutubeBundle\ConfigElementType\YoutubeReaderConfigElementType::TYPE] =
        '{title_type_legend},title,type;{config_legend},typeSelectorField,typeField,autoplay;';
    
    $fields = [
        'autoplay' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_module']['autoplay'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'w50 m12'],
            'sql'       => "char(1) NOT NULL default ''"
        ]
    ];
    
    $dca['fields'] = array_merge($dca['fields'],$fields);
}
<?php

$plugins = array();

 
$plugin_name = PKG_NAME_LOWER;
$content = getSnippetContent($sources['plugins'] . $plugin_name . '.plugin.php');

if(!empty($content)){

  /*
   * New plugin
   */
  
  $plugin = $modx->newObject('modPlugin');
  $plugin->set('id', 1);
  $plugin->set('name', $plugin_name );
  $plugin->set('description', $plugin_name.'_desc');
  $plugin->set('plugincode', $content );
  
  
  /* add plugin events */
  $events = array();
  
  $events['OnTVInputRenderList'] = $modx->newObject('modPluginEvent');
  $events['OnTVInputRenderList'] -> fromArray(array(
   'event' => 'OnTVInputRenderList',
   'priority' => 0,
   'propertyset' => 0,
  ),'',true,true);
  
  $events['OnLoadWebDocument'] = $modx->newObject('modPluginEvent');
  $events['OnLoadWebDocument'] -> fromArray(array(
   'event' => 'OnLoadWebDocument',
   'priority' => -100,
   'propertyset' => 0,
  ),'',true,true);
  
  $plugin->addMany($events, 'PluginEvents');
  
  $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events.'); flush();
  
  $plugins[] = $plugin;
}

unset($plugin,$events,$plugin_name,$content);
return $plugins;
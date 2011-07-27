<?php

class BaseaToolsHTMLWrapperSlotPlugin extends BaseaTools
{
  static public function getSlotTypesInfo($options)
  {
    $instance = sfContext::getInstance();
    $slotTypes = array_merge(
      array(
         'aText' => 'Plain Text',
         'aRichText' => 'Rich Text',
         'aFeed' => 'RSS Feed',
         'aSlideshow' => 'Photo Slideshow',
         'aSmartSlideshow' => 'Smart Slideshow',
         'aButton' => 'Button',
         'aAudio' => 'Audio',
         'aVideo' => 'Video',
         'aFile' => 'File',
         'aRawHTML' => 'Raw HTML'),
      sfConfig::get('app_a_slot_types', array()));
    if (isset($options['allowed_types']))
    {
      $newSlotTypes = array();
      foreach($options['allowed_types'] as $type)
      {
        if (isset($slotTypes[$type]))
        {
          $newSlotTypes[$type] = $slotTypes[$type];
        }
      }
      $slotTypes = $newSlotTypes;
    }
    $info = array();
    
    foreach ($slotTypes as $type => $label)
    {
      if (isset($options['type_options']) && isset($options['type_options'][$type]) && isset($options['type_options'][$type]['label']))
      {
        $label = $options['type_options'][$type]['label'];
      }
      $info[$type]['label'] = $label;
      // We COULD cache this. Would it pay to do so?
      $info[$type]['class'] = strtolower(preg_replace('/^a(\w)/', 'a-$1', $type));
    }
    return $info;
  }
  
  static public function setPageEnvironment(sfAction $action, aPage $page)
  {
    parent::setPageEnvironment($action, $page);
    
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
    
    // Title is pre-escaped as valid HTML
    $prefix = aTools::getOptionI18n('title_prefix');
    $suffix = aTools::getOptionI18n('title_suffix');
    $action->getResponse()->setTitle($prefix.__($page->getTitle()).$suffix, false);
  }
}

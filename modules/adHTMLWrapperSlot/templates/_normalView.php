<?php
  // Compatible with sf_escaping_strategy: true
  $editable = isset($editable) ? $sf_data->getRaw('editable') : null;
  $name = isset($name) ? $sf_data->getRaw('name') : null;
  $page = isset($page) ? $sf_data->getRaw('page') : null;
  $permid = isset($permid) ? $sf_data->getRaw('permid') : null;
  $pageid = isset($pageid) ? $sf_data->getRaw('pageid') : null;
  $slot = isset($slot) ? $sf_data->getRaw('slot') : null;
  $showEditButton = isset($showEditButton) ? $sf_data->getRaw('showEditButton') : null;
  $values = isset($values) ? $sf_data->getRaw('values') : null;
  //$value = isset($value) ? $values['text'] : null;
  $itemTemplate = isset($itemTemplate) ? $sf_data->getRaw('itemTemplate') : null;
?>
<?php use_helper('I18N') ?>
<?php include_partial('a/simpleEditWithVariants', array('name' => $name, 'permid' => $permid, 'pageid' => $pageid, 'slot' => $slot, 'showEditButton' => $showEditButton)) ?>
<?php if ($content !== false): ?>
  <?php echo $content ?>
<?php elseif ((!array_key_exists('text', $values) || !strlen($value)) && (!isset($options['optional']) || !$options['optional'])): ?>
  <?php if ($editable): ?>
    <?php echo __($emptyLabel, null, 'apostrophe') ?>
  <?php else: ?>
    <?php echo __('Please switch into edit mode to add content to this slot.', null, 'apostrophe') ?>
  <?php endif ?>
<?php elseif ((array_key_exists('text', $values) && strlen($values['text']) > 0) || (isset($options['optional']) && $options['optional'])): ?>
  <?php $text = array_key_exists('text', $values) ? $values['text'] : '' ?>
  <?php if (false !== $itemTemplate): ?>
    <?php echo str_replace('[[TEXT]]', get_partial('adHTMLWrapperSlot/'.$itemTemplate, array('text' => $text, 'name' => $name, 'permid' => $permid, 'pageid' => $pageid, 'page' => $page, 'slot' => $slot)), $wrap) ?>
  <?php else: ?>
    <?php /* TODO!!! Handle this nl2br business some other way: take a look at aText and a::textToHTML (or so :)) */ ?>
    <?php echo nl2br(str_replace('[[TEXT]]', $text, $wrap)) ?>
  <?php endif ?>
<?php endif ?>

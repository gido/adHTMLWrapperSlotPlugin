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
<?php elseif (array_key_exists('text', $values) && strlen($values['text']) > 0): ?>
  <?php if (false !== $itemTemplate): ?>
    <?php echo str_replace('[[TEXT]]', get_partial('adHTMLWrapperSlot/'.$itemTemplate, array('text' => $values['text'], 'name' => $name, 'permid' => $permid, 'pageid' => $pageid, 'slot' => $slot)), $wrap) ?>
  <?php else: ?>
    <?php /* TODO!!! Handle this nl2br business some other way: take a look at aText and a::textToHTML (or so :)) */ ?>
    <?php echo nl2br(str_replace('[[TEXT]]', $values['text'], $wrap)) ?>
  <?php endif ?>
<?php endif ?>

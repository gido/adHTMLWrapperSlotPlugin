<?php
class adHTMLWrapperSlotComponents extends BaseaSlotComponents
{
  public function executeEditView()
  {
    // Must be at the start of both view components
    $this->setup();
    
    // Careful, don't clobber a form object provided to us with validation errors
    // from an earlier pass
    if (!isset($this->form))
    {
      $this->form = new adHTMLWrapperSlotEditForm($this->id, $this->slot->getArrayValue());
    }
  }
  public function executeNormalView()
  {
    $this->setup();
    
    if ($this->getOption('saveOnCreation', false) && $this->slot->isNew())
    {
      $this->slot->setArrayValue(array('text' => ' '));
      $this->slot->save();
      $this->page->newAreaVersion($this->name, 'add', array('permid' => $this->permid, 'slot' => $this->slot,  'top' => sfConfig::get('app_a_new_slots_top', true)));
      
      $this->setup();
    }
    
    $this->values = $this->slot->getArrayValue();
    
    if (!empty($this->values['text']))
    {
    	$this->itemTemplate = $this->getOption('itemTemplate', false);
    }
    
    $this->content = $this->getOption('content', false);
    $this->showEditButton = $this->getOption('showEditButton', true);
    $this->wrap = $this->getOption('wrap', '[[TEXT]]');
    $this->emptyLabel = $this->getOption('emptyLabel', 'Click edit to add text.');
  }
}

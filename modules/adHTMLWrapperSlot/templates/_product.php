<div class="dm_product clearfix">
  <div class="dm_product_picture">
    <?php a_slot("picture-$pageid-$name-$permid", 'aImage', array(
      'defaultImage' => '/uploads/defaultImages/defaultImage_product_slot.png', 'width' => 200, 'flexHeight' => true)) ?>
  </div>
  <div class="dm_product_content">
    <h3><?php a_slot("heading-$pageid-$name-$permid", 'aText') ?></h3>
    <?php a_slot("subheading-$pageid-$name-$permid", 'adHTMLWrapper', array('allowed_variants' => array('wrap_in_paragraphs'))) ?>
    <?php a_slot("description-$pageid-$name-$permid", 'aRichText') ?>
    
    <a href="http://www.example.com" target="_blank" class="link">
      Hard-coded link (okay, this is uncommon but it's also just an example!)
    </a><br /><br />
    <?php a_area("additional-text-$pageid-$name-$permid", array(
      'allowed_types' => array('aText', 'adHTMLWrapper'), 
      'type_options' => array(
        'aText' => array('label' => 'Additional simple text'),
        'adHTMLWrapper' => array('allowed_variants' => array('wrap_in_paragraphs'), 'label' => 'Additional paragraphs')
      ))) ?>
  </div>
  <hr class="product_divider" />
</div>
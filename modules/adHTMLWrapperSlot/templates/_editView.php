<?php /* For this simple case we just want the form field without a label, and we know there are no validation errors to display */ ?>
<?php echo $form->renderHiddenFields() ?>
<?php echo $form['text']->render() ?>
<fieldset class="form-group <?php echo $class?>">
    <legend><?php echo $label?></legend>
    <?php foreach($elements as $element):?>
        <?php echo $element->render();?>
    <?php endforeach;?>
</fieldset>
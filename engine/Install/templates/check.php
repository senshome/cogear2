<p class="alert alert-info"><?php echo  t('Before start system must check your server for requirements. <br/>Just look at the table below and follow the instructions.') ?></p>
<?
$success = TRUE;
?>
<table id="requirements" class="table table-bordered table-striped">
    <thead>
    <th>#</th>
    <th><?php echo  t('Name') ?></th>
    <th><?php echo  t('Current') ?></th>
    <th><?php echo  t('Required') ?></th>
    <th><?php echo  t('Test') ?></th>
</thead>
<tbody>
    <?
    $success = FALSE;
    $php_version = phpversion();
    $passed = version_compare($php_version, '5.2.6', '>=');
    $success = $passed ? TRUE : FALSE;
    ?>
    <tr class="<?php echo  $passed ? 'success' : 'failure' ?>">
        <td>0.</td>
        <td><?php echo  t('PHP Version') ?></td><td>
            <?php echo  $php_version ?>
        </td><td>
            5.2.6
        </td>
        <td >
            <span class="label label-<?php echo  $passed ? 'success' : 'important' ?>"><?php echo  t($passed ? 'Passed' : 'Error') ?></span>
        </td>
    </tr>

    <?
    $passed = function_exists('spl_autoload_register');
    $success = $passed ? TRUE : FALSE;
    ?>
    <tr class="<?php echo  $passed ? 'success' : 'failure' ?>">
        <td>1.</td>
        <td colspan="3"><?php echo  t('SPL Library') ?></td>
        <td >
            <span class="label label-<?php echo  $passed ? 'success' : 'important' ?>"><?php echo  t($passed ? 'Passed' : 'Error') ?></span>
        </td>
    </tr>
    <?
    $passed = class_exists('ReflectionClass');
    $success = $passed ? TRUE : FALSE;
    ?>
    <tr class="<?php echo  $passed ? 'success' : 'failure' ?>">
        <td>2.</td>
        <td colspan="3"><?php echo  t('Reflections') ?></td>
        <td >
            <span class="label label-<?php echo  $passed ? 'success' : 'important' ?>"><?php echo  t($passed ? 'Passed' : 'Error') ?></span>
        </td>
    </tr>
    <?
    $passed = function_exists('filter_list');
    $success = $passed ? TRUE : FALSE;
    ?>
    <tr class="<?php echo  $passed ? 'success' : 'failure' ?>">
        <td>3.</td>
        <td colspan="3"><?php echo  t('Filters') ?></td>
        <td >
            <span class="label label-<?php echo  $passed ? 'success' : 'important' ?>"><?php echo  t($passed ? 'Passed' : 'Error') ?></span>
        </td>
    </tr>
    <?
    $passed = extension_loaded('iconv');
    $success = $passed ? TRUE : FALSE;
    ?>
    <tr class="<?php echo  $passed ? 'success' : 'failure' ?>">
        <td>4.</td>
        <td colspan="3"><?php echo  t('Iconv extension') ?></td>
        <td >
            <span class="label label-<?php echo  $passed ? 'success' : 'important' ?>"><?php echo  t($passed ? 'Passed' : 'Error') ?></span>
        </td>
    </tr>
    
    <?
    if (isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF']) OR isset($_SERVER['PATH_INFO'])) {
        $passed = TRUE;
    }
    else {
        $passed = FALSE;
    } 
    $success = $passed ? TRUE : FALSE;
    ?>
    <tr class="<?php echo  $passed ? 'success' : 'failure' ?>">
        <td>5.</td>
        <td colspan="3"><?php echo  t('URL rewrite') ?></td>
        <td >
            <span class="label label-<?php echo  $passed ? 'success' : 'important' ?>"><?php echo  t($passed ? 'Passed' : 'Error') ?></span>
        </td>
    </tr>
</tbody>
</table>
<? if ($success): ?>
    <p align="center">
        <a href="<?php echo  l('install/site') ?>" class="btn btn-primary"><?php echo  t('Continue') ?></a>
    </p>
    <?else:?>
    <?php echo error(t('Some of requirements are not satisfied.'))?>
    <a href="javascript:window.reload()" class="btn btn-warning"><?php echo t('Reload')?></a>
<? endif; ?>
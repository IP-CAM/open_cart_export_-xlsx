<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-backup" data-toggle="tooltip" title="<?php echo $button_export; ?>" class="btn btn-default"><i class="fa fa-download"></i></button>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" form="form-backup" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-exchange"></i> <?php echo $title; ?></h3>
            </div>
            <div class="well">
                <div class="row">

                    <div class="col-sm-4">
                        <form action="<?php echo $save?>" method="post" id="form-restore" class="form-horizontal">
                            <?php print_r($group_atributes_id['session']);?>
                        <div class="form-group"><?php echo '<pre>';print_r($get_group_atributes)?>
                            <select name="attribute_group_id" id="input-status" class="form-control">
                                <option value=""> </option>
                                <?php foreach ($get_group_atributes as $group_atributes)  { ?>

                               <option <?=$group_atributes_id['session'] === $group_atributes['attribute_group_id'] ? 'selected="selected"' : ''?> value="<?=$group_atributes['attribute_group_id']?>">
                                   <?=$group_atributes['name']?>
                               </option>
                                <?php }?>
                            </select>

                        </div>
                            <button type="submit" form="form-product" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">


                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>

                    <?php foreach ($group_atributes_id as $attr){
                        foreach ($attr as $key => $value){
                                foreach ($value['attribute'] as $item) { ?>
                        <td class="text-left"><?php echo $item['product_id']; ?></td>
                        <td class="text-left"><?php echo $item['name']; ?></td>


                                            <?php } }}?>



                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($uploads) { ?>
                    <?php foreach ($uploads as $upload) { ?>
                    <tr>
                        <td class="text-center"><?php if (in_array($upload['upload_id'], $selected)) { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $upload['upload_id']; ?>" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $upload['upload_id']; ?>" />
                            <?php } ?></td>
                        <td class="text-left"><?php echo $upload['name']; ?></td>
                        <td class="text-left"><?php echo $upload['filename']; ?></td>
                        <td class="text-right"><?php echo $upload['date_added']; ?></td>
                        <td class="text-right"><a href="<?php echo $upload['download']; ?>" data-toggle="tooltip" title="<?php echo $button_download; ?>" class="btn btn-info"><i class="fa fa-download"></i></a></td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        </div>


</div>
<?php echo $footer; ?>


<br />
<div class="row text-center blok ">

    <?php foreach($subcats as  $subcat){ ?>
            <div class="col-sm-3">

                <span class="subcat_name s1" data-subcatid="<?= $subcat->id ?>"> <?php echo $subcat->name;  ?> </span>

            </div>

    <?php }?>

</div>

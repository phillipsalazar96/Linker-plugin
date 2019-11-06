<?php
$name;
$url;

if ( ! empty( $_POST['name'] && !empty($_POST['url']) ) ) {

  $name = $links->stringSafe($_POST['name']);
  $url = $links->stringSafe($_POST['url']);
  $links->add_Item($name, $url);
}
else if (!empty($_POST['delete']))
{
  $links->delete_Item($_POST['delete']);
}
else if (!empty($_POST['name_update']) && !empty($_POST['url_update']))
{
  $name = $links->stringSafe($_POST['name_update']);
  $url = $links->stringSafe($_POST['url_update']);
  $links->update_Item($_POST['update'], $name, $url);
}


 ?>
 <div class="header-box">
  <h2>Linker Add a link!</h2>
</div>

<div class="input-area">
<div class="input-box">
<form method="post" action="">
    <h4>Add link</h4>
    <label>Name of link</label>
    <input type="text" name="name" />
    <label>Link</label>
    <input type="text" name="url" />
    <br/>
 <?php submit_button('Add link') ?>

</form>
</div>
<div class="input-box">
  <form method="post" action="">

      <h4>Update Link</h4>
      <label>Name of link</label>
      <input type="text" name="name_update" />
      <label>Link</label>
      <input type="text" name="url_update" />
      <select name="update">
        <option value="default">Default</option>
        <?php $stuff = $links->read_DB(); ?>
        <?php foreach ($stuff as $row): ?>
        <option value="<?php echo $row->id ?>"><?php echo $row->name ?></option>
          <?php endforeach; ?>
    </select>
  </br>

    <?php submit_button('Change link') ?>

  </form>
</div>
</div>
</br>
<br/>
<div class="link-box">
  <?php $stuff = $links->read_DB(); ?>
  <?php foreach ($stuff as $row): ?>
    <Div class="link-row">
    <span class="input-row"><p>Name: <a href="<?php echo $row->url ?>" target="_blank"><?php echo $row->name; ?></a></p></span>
    <span class="input-row"><p>Link: <a href="<?php echo $row->url ?>" target="_blank"><?php echo $row->url; ?></a></p></span>


    <form method="post" action="">
      <input type="hidden" name="delete" value="<?php echo $row->id ?>">
      <div class="delete-box">
      <?php submit_button('Delete link') ?>
    </div>
  </form>

</div>
  <?php endforeach; ?>
</div>

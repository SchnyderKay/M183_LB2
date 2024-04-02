<?php
require_once('includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');

    $options = array("Open", "In Progress", "Done");

    // read task if possible
    $title="";
    $state="";
    $taskid = "";

    if (isset($_GET['id'])){
        $taskid = $_GET["id"];
        $stmt = $conn->prepare("select ID, title, state from tasks where ID=?");

        // If preparing the statement fails exit or show error when in debug mode
        if ($stmt) {
            $stmt->bind_param("i", $taskid);
            if ($stmt->execute()){
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($db_id, $db_title, $db_state);
                    $stmt->fetch();
                    $title = $db_title;
                    $state = $db_state;
                } else {
                    errorHandlingPreparedStatement($stmt);
                }
            } else {
                errorHandlingPreparedStatement($stmt);
            }     
        } else {
            errorHandlingPreparedStatement($stmt);
        }

    }

    require_once 'fw/header.php';
?>

<?php if (isset($_GET['id'])) { ?>
    <h1>Edit Task</h1>
<?php }else { ?>
    <h1>Create Task</h1>
<?php } ?>

<form id="form" method="post" action="/savetask">
    <input type="hidden" name="id" value="<?php echo $taskid ?>" />
    <div class="form-group">
        <label for="title">Description</label>
        <input type="text" class="form-control size-medium" name="title" id="title" value="<?php echo $title ?>">
    </div>
    <div class="form-group">
        <label for="state">State</label>
        <select name="state" id="state" class="size-auto">
            <?php for ($i = 0; $i < count($options); $i++) : ?>
                <span><?php $options[1] ?></span>
                <option value='<?= strtolower($options[$i]); ?>' <?= $state == strtolower($options[$i]) ? 'selected' : '' ?>><?= $options[$i]; ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="submit" ></label>
        <input id="submit" type="submit" class="btn size-auto" value="Submit" />
    </div>
</form>
<script>
  $(document).ready(function () {
    $('#form').validate({
      rules: {
        title: {
          required: true
        }
      },
      messages: {
        title: 'Please enter a description.',
      },
      submitHandler: function (form) {
        form.submit();
      }
    });
  });
</script>

<?php
    require_once 'fw/footer.php';
?>
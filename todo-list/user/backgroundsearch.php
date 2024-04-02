<?php
require_once('includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');
?>
<section id="search">
    <h2>Search</h2>
    <form id="form" method="post" action="">
        <input type="hidden" id="searchurl" name="searchurl" value="/search/v2/" />
        <div class="form-group">
            <label for="terms">terms</label>
            <input type="text" class="form-control size-medium" name="terms" id="terms">
        </div>
        <div class="form-group">
            <label for="submit" ></label>
            <input id="submit" type="submit" class="btn size-auto" value="Submit" />
        </div>
    </form>
    <div id="messages">
        <div id="msg" class="hidden">The search is running. Results will be visible soon.</div>
        <div id="result" class="hidden"></div>
    </div>
    <script>
    $(document).ready(function () {
        $('#form').validate({
        rules: {
            terms: {
            required: true
            }
        },
        messages: {
            title: 'Please enter search terms.',
        },
        submitHandler: function (form) {
            provider = $("#searchurl").val();
            terms = $("#terms").val();
            userid = <?php echo $_SESSION['user_id'] ?>;
            $("#msg").show();
            $("#result").html("");
            $.post("/search/v2/index.php", { provider: provider, terms: terms, userid: userid }, function(data){
                $("#result").html(data);
                $("#msg").hide(500);
                $("#result").show(500);
            });
            return false;
            //form.submit();
        }
        });
    });
    </script>
</section>
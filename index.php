<?php
include('dbController.php');
$db_handle = new DBController();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>AI - Chat Bot</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link href="assets/images/favicon.ico" rel="shortcut icon">

    <!-- preloader css -->
    <link href="assets/css/preloader.min.css" rel="stylesheet" type="text/css"/>

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css"/>

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>

    <style>
        .main-content {
            margin-left: unset;
        }
    </style>

</head>

<body>

<!-- <body data-layout="horizontal"> -->

<!-- Begin page -->
<div id="layout-wrapper">

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="d-lg-flex">

                    <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
                        <div class="card">
                            <div class="chat-conversation p-3 px-2" data-simplebar>
                                <ul class="list-unstyled mb-0" id="ask">
                                </ul>
                            </div>

                            <div class="p-3 border-top">
                                <div class="row">
                                    <div class="col">
                                        <div class="position-relative">
                                            <select class="js-states form-control border bg-soft-light" id="single">
                                                <?php
                                                $data = $db_handle->runQuery("SELECT * FROM chat_answer order by id desc");
                                                $row_count = $db_handle->numRows("SELECT * FROM chat_answer order by id desc");
                                                for ($i = 0; $i < $row_count; $i++) {
                                                    ?>
                                                    <option value="<?php echo $data[$i]["question"]; ?>"><?php echo $data[$i]["question"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-primary chat-send w-md waves-effect waves-light"
                                                id="askbtn" type="button"><span
                                                    class="d-none d-sm-inline-block me-2">Ask</span> <i
                                                    class="mdi mdi-send float-end"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end user chat -->
                </div>
                <!-- End d-lg-flex  -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>

<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- pace js -->
<script src="assets/libs/pace-js/pace.min.js"></script>

<script src="assets/js/app.js"></script>
<script>
    $("#single").select2({
        placeholder: "Enter Question...",
        allowClear: true
    });

    $('#single').val(null).trigger('change');

    let question = [], answer = [];

    <?php
    $data = $db_handle->runQuery("SELECT * FROM chat_answer");
    $row_count = $db_handle->numRows("SELECT * FROM chat_answer");
    $question = '';
    $answer = '';
    for ($i = 0; $i < $row_count; $i++) {
        $question .= "'" . $data[$i]["question"] . "',";
        $answer .= "'" . $data[$i]["answer"] . "',";
    }
    ?>
    question.push(<?php echo substr($question, 0, -1); ?>);
    answer.push(<?php echo substr($answer, 0, -1); ?>);


    $("#askbtn").click(function () {

        let chat_question = $('#single').val(), chat_answer = '';

        for (let i = 0; i < question.length; i++) {
            if (chat_question == question[i]) {
                chat_answer = answer[i];
            }
        }

        if (chat_question == null || chat_question == '') {
            alert('Please Input Value');
        } else {
            $("#ask").append(' <li class="right">\n' +
                '                                        <div class="conversation-list">\n' +
                '                                            <div class="ctext-wrap">\n' +
                '                                                <div class="ctext-wrap-content">\n' +
                '                                                    <p class="mb-0">' + chat_question + '</p>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '\n' +
                '                                    </li>');

            $("#ask").append('<li>\n' +
                '                                        <div class="conversation-list">\n' +
                '                                            <div class="ctext-wrap">\n' +
                '                                                <div class="ctext-wrap-content">\n' +
                '                                                    <p class="mb-0">'+chat_answer+'</p>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </li>');

        }
    });
</script>
</body>
</html>

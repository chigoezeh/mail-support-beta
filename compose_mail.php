<?php
    //  Require the important configuration file.
    require_once 'config.php';

    //  Check if user is already logged. If false, take user to the log in page.
    if (!ACTIVE_USER_ACCOUNT || ACTIVE_USER_ACCOUNT['USER_TYPE'] !== 'admin') {
        header('Location: login.php');
    }
    
    if (isset($_POST['email_content'])) {
        if ($exsup->ValidateEmail($_POST['recipient'])) {
            $recipient = $_POST['recipient'];
            $subject = $_POST['subject'];
            $content = $_POST['email_content'];
            $clientName = explode('@', $recipient)[0];
            $clientName = '';

            $sendMail = $exsup->SendMail($recipient, $clientName, $subject, $content);

            if ($sendMail) {
                // /
            }else {
                //
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <?php
        $_page_title = 'Compose Email Message';
        $editor_plugin = true;
        include_once 'includes/head.php';
    ?>
    <body>
        <?php
            $__set_active = 'comm';
            include_once 'includes/header.php';
        ?>
        <section>
            <style>
                body {
                    background-color: #f7f7f7;
                }
                .__writer_toolbar * {
                    box-sizing: content-box;
                }
                .__writer_toolbar {
                    position: relative;
                    text-align: center;
                    padding-bottom: 12px;
                    border-bottom: 1px solid #eee;
                    margin-bottom: 8px;
                }
                .__writer_toolbar a,
                .fore-wrapper,
                .back-wrapper {
                    border: 1px solid #aaa;
                    background: #fff;
                    font-family: 'Candal';
                    border-radius: 1px;
                    color: black;
                    padding: 5px;
                    width: 1.5em;
                    margin: -2px;
                    margin-top: 10px;
                    display: inline-block;
                    text-decoration: none;
                    box-shadow: 0px 1px 0px #ccc;
                }
                .__writer_toolbar a:hover,
                .fore-wrapper:hover,
                .back-wrapper:hover {
                    background: #f2f2f2;
                    border-color: #8c8c8c;
                }
                a[data-command='redo'],
                a[data-command='strikeThrough'],
                a[data-command='justifyFull'],
                a[data-command='insertOrderedList'],
                a[data-command='outdent'],
                a[data-command='p'],
                a[data-command='superscript'] {
                    margin-right: 5px;
                    border-radius: 0 3px 3px 0;
                }
                a[data-command='undo'],
                .fore-wrapper,
                a[data-command='justifyLeft'],
                a[data-command='insertUnorderedList'],
                a[data-command='indent'],
                a[data-command='h1'],
                a[data-command='subscript'] {
                    border-radius: 3px 0 0 3px;
                }
                a.palette-item {
                    height: 1em;
                    border-radius: 3px;
                    margin: 2px;
                    width: 1em;
                    border: 1px solid #ccc;
                }
                a.palette-item:hover {
                    border: 1px solid #ccc;
                    box-shadow: 0 0 3px #333;
                }
                .fore-palette,
                .back-palette {
                    display: none;
                }
                .fore-wrapper,
                .back-wrapper {
                    display: inline-block;
                    cursor: pointer;
                }
                .fore-wrapper:hover .fore-palette,
                .back-wrapper:hover .back-palette {
                    display: block;
                    float: left;
                    position: absolute;
                    padding: 3px;
                    width: 160px;
                    background: #fff;
                    border: 1px solid #ddd;
                    box-shadow: 0 0 5px #ccc;
                    height: 70px;
                }
                .fore-palette a,
                .back-palette a {
                    background: #fff;
                    margin-bottom: 2px;
                }
                .__writer_toolbar .__writer_mode {
                    border: 1px solid #aaa;
                    background: #fff;
                    border-radius: 1px;
                    color: black;
                    padding: 5px;
                    margin: -2px;
                    margin-top: 10px;
                    display: inline-block;
                    text-decoration: none;
                    box-shadow: 0px 1px 0px #ccc;
                    cursor: pointer;
                }
                .__writer_toolbar .__writer_mode.isActive {
                    background: #eee;
                }
                .__writer_toolbar .__left {
                    border-radius: 3px 0 0 3px;
                }
                .__writer_toolbar .__right {
                    border-radius: 0 3px 3px 0;
                }
                .__writer_toolbar .__writer_mode:hover {
                    background: #f2f2f2;
                    border-color: #8c8c8c;
                }
                .__writeer_Editor {
                    position: relative;
                    min-height: 450px;
                    height: auto;
                    overflow: hidden;
                    overflow-y: auto;
                    padding: 10px;
                    display: block;
                    margin-top: 20px;
                    resize: none;
                    outline: none;
                    border-radius: 1px;
                    border: 1px solid #ddd;
                }
            </style>
            <div class="row row-md margin-b-lg">
                <div class="columns">
                    <div style="padding: 12px 0;">
                        <h1 class="font-size-30" style="margin-bottom: 8px;">Compose Email</h1>
                    </div>
                </div>
                <div class="large-12 medium-12 columns">
                    <div class="card">
                        <div class="card-body">
                            <form id="compose_mail" action="compose_mail.php" method="POST" autocomplete="off">
                                <div class="row">
                                    <div class="large-6 medium-6 columns no-padding" style="padding-right: 2px;">
                                        <div class="form-group">
                                            <label>Recipient</label>
                                            <input class="form-control" name="recipient" type="text" value="" placeholder="To" required="required">
                                        </div>
                                    </div>
                                    <div class="large-6 medium-6 columns no-padding" style="padding-left: 2px;">
                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input class="form-control" name="subject" type="text" placeholder="Subject" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="__writer_toolbar" id="toolbar">
                                    <a href="#" data-command="undo"><i class="mdi mdi-undo-variant"></i></a>
                                    <a href="#" data-command="redo"><i class="mdi mdi-redo-variant"></i></a>
                                    <!-- <div class="fore-wrapper"><i class="fa fa-font" style="color:#c96;"></i>
                                        <div class="fore-palette"></div>
                                    </div>
                                    <div class="back-wrapper"><i class='fa fa-font' style='background:#c96;'></i>
                                        <div class="back-palette"></div>
                                    </div> -->
                                    <style>
                                        .__write_news_toolbar .__writer_mode.isActive {
                                            background: #eee;
                                        }
                                    </style>
                                    <a href="#" data-command='bold'><i class='fa fa-bold'></i></a>
                                    <a href="#" data-command='italic'><i class='fa fa-italic'></i></a>
                                    <a href="#" data-command='underline'><i class='fa fa-underline'></i></a>
                                    <a href="#" data-command='strikeThrough'><i class='fa fa-strikethrough'></i></a>
                                    <a href="#" data-command='justifyLeft'><i class='fa fa-align-left'></i></a>
                                    <a href="#" data-command='justifyCenter'><i class='fa fa-align-center'></i></a>
                                    <a href="#" data-command='justifyRight'><i class='fa fa-align-right'></i></a>
                                    <a href="#" data-command='justifyFull'><i class='fa fa-align-justify'></i></a>
                                    <a href="#" data-command='indent'><i class='fa fa-indent'></i></a>
                                    <a href="#" data-command='outdent'><i class='fa fa-outdent'></i></a>
                                    <a href="#" data-command='insertUnorderedList'><i class='fa fa-list-ul'></i></a>
                                    <a href="#" data-command='insertOrderedList'><i class='fa fa-list-ol'></i></a>
                                    <a href="#" data-command='blockquote'><i class='mdi mdi-format-quote-close'></i></a>
                                    <a href="#" data-command='h1'>H1</a>
                                    <a href="#" data-command='h2'>H2</a>
                                    <a href="#" data-command='createlink'><i class='fa fa-link'></i></a>
                                    <a href="#" data-command='unlink'><i class='fa fa-unlink'></i></a>
                                    <a href="#" data-command='p'>P</a>
                                    <a href="#" data-command='subscript'><i class='fa fa-subscript'></i></a>
                                    <a href="#" data-command='superscript'><i class='fa fa-superscript'></i></a>
                                    <span id="__write_switch_design" class="__writer_mode __left isActive">Design</span>
                                    <span id="__write_switch_html" class="__writer_mode __right">HTML</span>
                                </div>
                                <div id="editor" class="__writeer_Editor" contenteditable="true"></div>
                                <textarea id="content" class="__writeer_Editor" name="email_content" style="width: calc(100% - 22px); min-height: 1px; height: 1px; margin-bottom: 8px; visibility: hidden;"></textarea>
                                <div class="text-left">
                                    <button id="sendMail" class="btn btn-primary" name="sendmail" style="padding: 8px 28px;">Send Mail</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            var f = document.querySelector('#compose_mail');
            var editorDiv = document.getElementById('editor');
            var mailContent = document.getElementById('content');
            var btn = document.getElementById('sendMail');

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                mailContent.value = editorDiv.innerHTML;
                f.submit();
                //return;
            });
            
            var toolbar_command = document.querySelectorAll('.__writer_toolbar a');
            toolbar_command.forEach(c => {
                c.addEventListener('click', function(e) {
                    e.preventDefault();
                    var command = this.dataset.command;
                    if (command == 'h1' || command == 'h2' || command == 'p' || command == 'blockquote') {
                        document.execCommand('formatBlock', false, command);
                    }
                    if (command == 'forecolor' || command == 'backcolor') {
                        document.execCommand(this.dataset.command, false, this.dataset.value);
                    }
                    if (command == 'createlink' || command == 'insertimage') {
                        url = prompt('Enter the link here: ', 'http:\/\/');
                        document.execCommand(this.dataset.command, false, url);
                    } else document.execCommand(this.dataset.command, false, null);

                    return false;
                });
            });
            var switchDesign = document.querySelector('#__write_switch_design');
            var switchHTML = document.querySelector('#__write_switch_html');

            switchDesign.addEventListener('click', function() {
                toggleWriterSwitch(this, false);
            });

            switchHTML.addEventListener('click', function() {
                toggleWriterSwitch(this);
            });

            function toggleWriterSwitch(el, mode = true) {
                //  Remove the indicator class from all similar button.
                document.querySelectorAll('.__writer_mode').forEach(w => {
                    if (w.classList.contains('isActive')) {
                        w.classList.remove('isActive');
                    }
                });
                //  Add the indicator class to the clicked mode.
                el.classList.add('isActive');

                //  Switch the editor mode.
                if (mode) {
                    mailContent.value = editorDiv.innerHTML;
                    editorDiv.style.display = 'none';
                    mailContent.style.minHeight = '';
                    mailContent.style.height = 'auto';
                    mailContent.style.visibility = 'visible';
                    //  min-height: 1px; height: 1px; visibility: hidden;
                }else {
                    editorDiv.innerHTML = mailContent.value;
                    editorDiv.style.display = '';
                    mailContent.style.minHeight = '1px';
                    mailContent.style.height = '1px';
                    mailContent.style.visibility = 'hidden';
                }
            }

        </script>
    </body>
</html>
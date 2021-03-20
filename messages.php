<?php
function display_error($error_string){
    return "<div class='block'>
                    <article class='message is-danger'>
                          <div class='message-header'>
                                <p>Error</p>
                          </div>
                          <div class='message-body'>
                                $error_string
                          </div>
                    </article>
                </div>";
}

function display_success($success_string){
    return "<div class='block'>
                    <article class='message is-success'>
                          <div class='message-header'>
                                <p>Success</p>
                          </div>
                          <div class='message-body'>
                                $success_string
                          </div>
                    </article>
                </div>";
}




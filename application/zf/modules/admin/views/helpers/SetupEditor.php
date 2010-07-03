<?php

class Admin_View_Helper_SetupEditor
{
    public function setupEditor($textareaID){


        return "<script type=\"text/javascript\">
            CKEDITOR.replace('".$textareaID."' ,
            {
                filebrowserBrowserUrl : '/js/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
                filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Flash',
                filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images'
            }
            );
            </script>";
        
    }
}

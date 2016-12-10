function base_url(){
    var server = window.location.hostname;
    var url = "";
    if(server == 'localhost')
        string = window.location.protocol+"//"+window.location.host+"/ci_doctrine_twig/";
    else
        string = window.location.protocol+"//"+window.location.host+"/";

    return string;
}

$(document).ready(function(){

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Editor de HTML - Conteúdo do Post
    $('.htmleditor').tinymce({
        // selector:'.htmleditor',
        script_url: base_url()+'htmleditor/tinymce.min.js',
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        language: 'pt_BR',
        language_url: '../../htmleditor/langs/pt_BR.js',
        content_css: '../../bower_components/bootstrap/dist/css/bootstrap.min.css',
        image_advtab: true
        // image_prepend_url: base_url()+'/uploads/',
        // image_list: base_url()+'/admin/midia/get_midias'
        // image_prepend_url: 'http://localhost:8080/meu_projeto/uploads/',
        // image_list: 'http://localhost:8080/meu_projeto/admin/midia/get_midias'
    });

});
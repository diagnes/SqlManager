function tableCreate(data){
    var datatable = $('<table class="table table-hover"></table>');
    var datath = $('<th></th>');
    var datatd = $('<td></td>');
    var datatr = $('<tr></tr>');
    var row,label,info, a;

    for(var i = 0; i < data.length; i++){
        row = data[i];
        label = $(datatr).clone();
        info = $(datatr).clone();
        for (var key in row) {
            if (i == 0){
                a = $(datath).clone();
                $(label).append(a.html(key));
            }
            a = $(datatd).clone();
            $(info).append(a.html(row[key]));
        }
        if (i == 0){
            $(datatable).append(label)
        }
        $(datatable).append(info)
    }
    return datatable;
}

function historiqueConstruct(data){
    $('.history').html('');
    $('.history').append('<h2>Historique</h2>');
    for(var i = 0; i < data.length; i++){
        $('.history').append('<a href="javascript:void(0)" class="story-link" data-request="' + data[i].request +'" data-bdd="' + data[i].bdd +'">' + data[i].label + '</a>');
    }
}

function databaseConstruct(data){
    var opt = $('<option></option>');
    var a;
    $('select[name="bdd"]').html('');
    $('select[name="bdd"]').append($('<option>Aucune</option>'));
    for(var i = 0; i < data.length; i++){
        a = $(opt).clone()
        a.val(data[i]).html(data[i]);
        $('select[name="bdd"]').append(a);
    }
    if (data.length == 0){
        $('select[name="bdd"]').append("<p>" + "Aucune table n'a été trouvée" + "</p>");
    }
}

function tableConstruct(data){
    var lab = $('<div class="label label-info"></div>');
    var a;

    $('.table-disp').html('');

    for(var i = 0; i < data.length; i++){
        a = $(lab).clone();
        a.val(data[i]).html(data[i]);
        $('.table-disp').append(a);
    }
    $('.table-disp').closest('.form-group').removeClass('hide');
}

$(document).ready(function(){

    function initForm(data){
        var db = $('select[name="bdd"]').val();
        $.ajax({
            url: 'init.php',
            type: 'POST',
            data : data,
            dataType: 'json',
            success: function (data) {
                if (data.Historique.success){
                    historiqueConstruct(data.Historique.data);
                }else{
                    $('.alert.historique').removeClass('hide').find('.my-error').html(data.Db.data);
                }

                if (data.Db.success){
                    databaseConstruct(data.Db.data);
                    $('select[name="bdd"]').val(db);
                }else{
                    $('.alert.db').removeClass('hide').find('.my-error').html(data.Db.data);
                }

                if (data.Table != undefined && data.Table.success){
                    tableConstruct(data.Table.data);
                }
            }
        });
    }

    initForm(false);

    $('select[name="bdd"]').on('change', function(){
        var data = $(this).closest('form').serialize();
        $('.alert').addClass('hide');
        initForm(data);
    });

    $('.request-form').on('submit', function(){

        var data = $(this).closest('form').serialize();
        var btn = $(this).find('button');
        var request = $(this).find('[name="request"]').val();

        $('.alert').addClass('hide');
        btn.removeClass('btn-danger').html('En cours...');

        $.ajax({
            url : 'manage.php',
            type : 'POST',
            data : data,
            dataType: 'json',
            success : function(data){
                $('.request-data').html('');
                if (data.success){
                    var myTable = tableCreate(data.data);
                    $('.request-data')
                        .append('<h2>Résultat de la requete</h2>')
                        .append('<p>Request: ' + request +'</p>')
                        .append('<p>BDD: DspSQL</p>')
                        .append('<p>Lignes concsernée '+ data.data.length +'</p>')
                        .append(myTable);
                    btn.addClass('btn-success').html('Succès');
                }else{
                    btn.addClass('btn-danger').html('Erreur');
                    $('.alert.db').removeClass('hide').find('.my-error').html(data.data);
                }
            }
        });
        initForm();
        return false;
    });

    $(document).on('click', ".story-link", function() {

        var data = encodeURI('bdd=' + $(this).attr('data-bdd') + '&request=' + $(this).attr('data-request'));
        console.log(data);
        $.ajax({
            url : 'manage.php',
            type : 'POST',
            data : data,
            dataType: 'json',
            success : function(data){
                $('.request-data').html('');
                console.log(data);
                if (data.success){
                    var myTable = tableCreate(data.data);
                    $('.request-data')
                        .append('<h2>Résultat de la requete</h2>')
                        .append('<p>Request: ' + request +'</p>')
                        .append('<p>BDD: DspSQL</p>')
                        .append('<p>Lignes concsernée '+ data.data.length +'</p>')
                        .append(myTable);
                }else{
                    $('.alert.db').removeClass('hide').find('.my-error').html(data.data);
                }
            }
        });
        initForm();
        return false;
    });


});
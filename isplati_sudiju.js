$(document).ready(function(){
    $('#korisnik').change(function(){
        var selectedUserID = $(this).val();
        if(selectedUserID !== '') {
            $.ajax({
                url: 'fetch_records.php',
                method: 'POST',
                data: { korisnikID: selectedUserID },
                success: function(response){
                    $('#userRecordsTable tbody').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#userRecordsTable tbody').html("<tr><td colspan='4'>Error occurred while fetching records.</td></tr>");
                }
            });
        } else {
            $('#userRecordsTable tbody').html("<tr><td colspan='4'>No user selected.</td></tr>");
        }
    });
});

$(document).ready(function(){
    $('#korisnik').change(function(){
        var selectedUserID = $(this).val();
        if(selectedUserID !== '') {
            $.ajax({
                url: 'troskovi.php',
                method: 'POST',
                data: { korisnikID: selectedUserID },
                success: function(response){
                    $('#userRecordsTable2 tbody').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#userRecordsTable2 tbody').html("<tr><td colspan='4'>Error occurred while fetching records.</td></tr>");
                }
            });
        } else {
            $('#userRecordsTable2 tbody').html("<tr><td colspan='4'>No user selected.</td></tr>");
        }
    });
});

$(document).ready(function() {
    $('#korisnik').change(function() {
        var selectedUserID = $(this).val();
        if(selectedUserID !== '') {
            $('#noUserMessage').hide();
            $('#noUserMessage2').hide();
        } else {
            $('#noUserMessage').show();
            $('#noUserMessage2').show();
        }
    });
});

$(document).ready(function() {
$('#korisnik').change(function() {
    var selectedUserID = $(this).val();
    if (selectedUserID !== '') {
        $.ajax({
            url: 'process_form.php',
            method: 'POST',
            data: { korisnikID: selectedUserID },
            dataType: 'json',
            success: function(response) {
                $('#sumUplata').html("Ispalcene utakmice: " + response.sum_uplata);
                $('#sumIsplacenaputarina').html("Isplacena putarina: " + response.sum_isplacenaputarina);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $('#sumUplata').html("Error occurred while fetching sum.");
                $('#sumIsplacenaputarina').html("Error occurred while fetching sum.");
            }
        });
    } else {
        $('#sumUplata').html("");
        $('#sumIsplacenaputarina').html("");
    }
});
});
$(document).ready(function() {
    selesai();
});
 
function selesai() {
    setTimeout(function() {
        update();
        selesai();
    }, 200);
}
 
function update() {
    $.getJSON("update.php", function(data) {
        $("secondHeading").empty();
        var no = 1;
        $.each(data.result, function() {
            $("secondHeading").append(office[3]);
        });
    });
}

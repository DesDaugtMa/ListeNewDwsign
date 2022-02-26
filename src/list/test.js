var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);

var htmlText = "";

$.ajax({
    type: "POST",
    url: 'test.php',
    success: function(data){
        const obj = JSON.parse(data);
        obj.forEach(element => {
            htmlText += `<div class="col-sm-4">
                            <div class="white_container_list">
                                <strong>` + element.name + `</strong>
                                <span style="float: right;">
                                    <i class="bi bi-pencil btn_hover" style="margin-right: 2vh;" onclick="showModal('edit', 1);"></i>
                                    <i class="bi bi-trash text-danger btn_hover" onclick="showModal('delete', 1);"></i>
                                </span>
                                <hr>
                                <p style="color: orange;"><i class="bi bi-star-fill"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i></p>
                                <p class="modal_label">Aktivität: ` + element.activity + `</p>
                                <p class="modal_label">Ort: ` + element.location + `</p>
                                <p class="modal_label">Notizen: ` + element.note + `</p>
                            </div>
                        </div>`
        });

        document.getElementById('test').innerHTML = htmlText;
    },
    error: function (Status, errorThrown) {
    }  
});

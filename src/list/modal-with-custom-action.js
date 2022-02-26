var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);


// Learn Template literals: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals
// Learn about Modal: https://getbootstrap.com/docs/5.0/components/modal/

var modalWrap = null;
/**
 * 
 * @param {string} title 
 * @param {string} description content of modal body 
 * @param {string} yesBtnLabel label of Yes button 
 * @param {string} noBtnLabel label of No button 
 * @param {function} callback callback function when click Yes button
 */
const showModal = (type, id, callback) => {
var test1234 = getNameById(id);


    if (modalWrap !== null) {
        modalWrap.remove();
    }

    modalWrap = document.createElement('div');

    if(type === "add"){
        modalWrap.innerHTML = `
            <div class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title">Hinzufügen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Add</p>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-success modal-success-btn" data-bs-dismiss="modal">Hinzufügen</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else if (type === "edit"){
        modalWrap.innerHTML = `
            <div class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title">Bearbeiten</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Du hast ${id} ausgewählt</p>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-success modal-success-btn" data-bs-dismiss="modal">Speichern</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else if (type === "delete"){
        modalWrap.innerHTML = `
            <div class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title">Löschen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Möctest du ` + getNameById(id) + ` wirklich löschen?</p>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-danger modal-success-btn" data-bs-dismiss="modal">Löschen</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    modalWrap.querySelector('.modal-success-btn').onclick = callback;

    document.body.append(modalWrap);

    var modal = new bootstrap.Modal(modalWrap.querySelector('.modal'));
    modal.show();
}

function getNameById(id){
    var tmp = null;
    $.ajax({
        async: false,
        type: "POST",
        url: 'functions.php',
        dataType: 'json',
        data: {functionname: 'getNameById', arguments: [id]},
    
        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                          tmp = obj.result;
                      }
                      else {
                          console.log(obj.error);
                      }
                }
    });

    return tmp;
}


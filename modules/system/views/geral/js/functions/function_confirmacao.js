function confirmacao(msgQ) {
    var msg = '';
    
    switch (msgQ) {
        case 2: msg = 'Tem certeza que deseja aplicar esta ação aos registros selecionados?'; break;
        case 3: msg = 'Tem certeza que deseja excluir o produto selecionado?'; break;
        case 4: msg = 'Tem certeza que deseja aplicar esta ação?'; break;
        default: msg = 'Tem certeza que deseja excluir os registros selecionados?'; break;
    }
    
    return confirm(msg) ? true : false;
}

function doYouConfirm(msg) {
    return confirm(msg) ? true : false;
}
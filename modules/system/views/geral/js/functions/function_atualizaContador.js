/**
 * dateTime (YYYY-mm-dd H:i:s) <br />
 * IDcounter (Id do elemento p atualizar)
 */

function atualizaContador(dateTime, IDcounter) {
    var YY = dateTime.substr(0, 4);
    var MM = dateTime.substr(5, 2);
    var DD = dateTime.substr(8, 2);
    var HH = dateTime.substr(11, 2);
    var MI = dateTime.substr(14, 2);
    var SS = dateTime.substr(17, 2);
    var hoje = new Date();
    var futuro = new Date(YY, MM - 1, DD, HH, MI, SS);
    
    var ss = parseInt((futuro - hoje) / 1000);
    var mm = parseInt(ss / 60);
    var hh = parseInt(mm / 60);
    var dd = parseInt(hh / 24);

    ss = ss - (mm * 60);
    mm = mm - (hh * 60);
    hh = hh - (dd * 24);

    var faltam = '';
    faltam += '<div class="hh_mm_ss">';
    faltam += dd ? (dd < 10 ? '0' + dd : dd) + (dd > 1 ? ' dias' : ' dia') + '</div><div class="dois_pontos">,&nbsp;</div><div class="hh_mm_ss">' : '';
    faltam += (toString(hh).length) ? (hh < 10 ? '0' + hh : hh) + ' h</div><div class="dois_pontos">&nbsp;:&nbsp;</div><div class="hh_mm_ss">' : '';
    faltam += (toString(mm).length) ? (mm < 10 ? '0' + mm : mm) + ' m</div><div class="dois_pontos">&nbsp;:&nbsp;</div><div class="hh_mm_ss">' : '';
    faltam += (ss < 10 ? '0' + ss : ss) + ' s';
    faltam += '</div>';

    if (dd + hh + mm + ss > 0) {
        document.getElementById(IDcounter).innerHTML = faltam;
        setTimeout(function(){
            atualizaContador(dateTime, IDcounter);
        }, 1000);
    } else {
        document.getElementById(IDcounter).innerHTML = '<div class="hh_mm_ss">00</div><div class="dois_pontos">:</div><div class="hh_mm_ss">00</div><div class="dois_pontos">:</div><div class="hh_mm_ss">00</div>';
        setTimeout(function(){
            atualizaContador(dateTime, IDcounter);
        }, 1000);
    }
}
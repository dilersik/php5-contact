function replaceAll(string, token, newtoken) {
	if (typeof string != "undefined") {
		while (string.indexOf(token) != -1) {
			string = string.replace(token, newtoken);
		}
	}

    return string;
}

function replaceAllMoneyBR(string) {
    string = replaceAll(string, 'R$', '');
    string = replaceAll(string, ' ', '');
    string = replaceAll(string, '.', '');
    string = replaceAll(string, ',', '.');
    string = replaceAll(string, 'kg', '');
    string = replaceAll(string, 'm', '');
    string = replaceAll(string, '%', '');
    string = replaceAll(string, '°C', '');
    string = replaceAll(string, 'L', '');
    string = replaceAll(string, '%', '');

    if (isNaN(string)) {
        string = 0;
    }

    return parseFloat(string);
}
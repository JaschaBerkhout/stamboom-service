var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (g && (g = 0, op[0] && (_ = 0)), _) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
function fetchPersonsForUser(id) {
    return __awaiter(this, void 0, void 0, function () {
        var response;
        return __generator(this, function (_a) {
            switch (_a.label) {
                case 0: return [4 /*yield*/, fetch('http://localhost:8000/?type=personen_json&user_id=' + id)];
                case 1:
                    response = _a.sent();
                    if (!response.ok) return [3 /*break*/, 3];
                    return [4 /*yield*/, response.json()];
                case 2: return [2 /*return*/, _a.sent()];
                case 3:
                    alert("HTTP-Error: " + response.status);
                    return [2 /*return*/, []];
            }
        });
    });
}
function refreshFamilyTree(id) {
    fetchPersonsForUser(id).then(function (personsFromData) {
        if (personsFromData.length === 0) {
            console.log("Geen personen gevonden");
            return;
        }
        console.log(personsFromData);
        var persons = [];
        personsFromData.forEach(function (persoon) {
            if (persoon === null) {
                return;
            }
            persons.push(new Persoon(persoon.id, persoon.f_name, persoon.l_name, persoon.gender, persoon.birthday, persoon.user_id, persoon.deathday));
        });
        updateSummary(personsFromData.length);
        updateFamilyTreeOnWebpage(persons);
    });
}
;
refreshFamilyTree(1);
function allOfTheFamily(persons) {
    var result = '';
    persons.forEach(function (person) { return result += personCard(person); });
    return result;
}
;
function updateFamilyTreeOnWebpage(persons) {
    var personenElement = document.getElementById('personen');
    personenElement.innerHTML = allOfTheFamily(persons);
}
;
function personCard(person) {
    return "<div class='" + (person.gender === 'm' ? 'man' : 'vrouw') + " persoon'>" + person.name() +
        ' <br> ' + person.getAgeOfPerson() +
        ' jaar' +
        ' <br>* ' +
        person.niceDateFormat(person.birthday) +
        ' <br>' +
        (person.isPassedAway() ? '✝ ' + person.niceDateFormat(person.deathday) : '') +
        '</div>';
}
;
var Persoon = /** @class */ (function () {
    function Persoon(id, f_name, l_name, gender, birthday, user_id, deathday) {
        this.persons = allOfTheFamily(1);
        this.id = id;
        this.f_name = f_name;
        this.l_name = l_name;
        this.gender = gender;
        this.birthday = birthday;
        this.user_id = user_id;
        this.deathday = deathday;
    }
    Persoon.prototype.name = function () {
        return this.f_name + ' ' + this.l_name;
    };
    /**
     * yolo
     * @param startDatum
     * @param eindDatum
     */
    Persoon.prototype.getAge = function (startDatum, eindDatum) {
        var leeftijd = eindDatum.getFullYear() - startDatum.getFullYear();
        var maand = eindDatum.getMonth() - startDatum.getMonth();
        var dag = eindDatum.getDate() - startDatum.getDate();
        if (maand < 0 || (maand === 0 && dag < 0)) {
            return leeftijd - 1;
        }
        return leeftijd;
    };
    Persoon.prototype.getAgeOfPerson = function () {
        var geboortedatum = new Date(this.birthday);
        if (!this.isPassedAway()) {
            var vandaag = new Date();
            return this.getAge(geboortedatum, vandaag);
        }
        var overlijdensdatum = new Date(this.deathday);
        return this.getAge(geboortedatum, overlijdensdatum);
    };
    Persoon.prototype.niceDateFormat = function (datum) {
        return new Date(datum).toLocaleDateString('nl-nl');
    };
    Persoon.prototype.isPassedAway = function () {
        return this.deathday !== null;
    };
    Persoon.prototype.numberOfPersons = function () {
        return this.persons.length;
    };
    return Persoon;
}());
;
function updateSummary(numberOfPersons) {
    var samenvatting = document.getElementById('samenvatting');
    // if samenvatting is niet gelijk aan tekst niet doen anders
    var summaryText = function () {
        if (numberOfPersons === 1) {
            return "De familie bevat nu ".concat(numberOfPersons, " persoon.");
        }
        else {
            return "De familie bevat nu ".concat(numberOfPersons, " personen.");
        }
    };
    samenvatting.innerHTML = summaryText();
}
;
function generalMessage(tekst) {
    var meldingElement = document.getElementById('melding');
    meldingElement.innerHTML = tekst;
    removeMessage();
}
;
function removeMessage() {
    setTimeout(function () { return document.getElementById('melding').innerHTML = ''; }, 5000);
}
;
// zodra form werkt deze eraan koppelen.
function messageNewPersonCreated(persoon) {
    generalMessage("".concat(persoon.f_name, " is toegevoegd aan de familie ").concat(persoon.l_name, "."));
}
;
function showPassword() {
    var password = document.getElementById("password");
    if (password.type === "password") {
        password.type = "text";
    }
    else {
        password.type = "password";
    }
}
//# sourceMappingURL=stamboom.js.map
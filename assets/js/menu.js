const suffixes = ["","JR","SR","I","II","III","IV",];
const courses = [
    "Bachelor of Science in Information Technology",
    "Bachelor of Science in Hospitality Management",
    "Bachelor of Science in Criminology",
    "Bachelor of Science in Business Administration",
    "Bachelor of Education Major in English",
    "Bachelor of Education Major in Math"
];
const cities = [
    "Manila",
    "Quezon City",
    "Davao",
    "Caloocan City",
    "Canagatan",
    "Taguig City",
    "Pasig City",
    "Valenzuela",
    "City of Parañaque",
    "Bacoor",
    "Tondo",
    "Las Piñas City",
    "Pasay City",
    "Mandaluyong City",
    "Malabon",
    "San Pedro",
    "Navotas",
    "Santa Ana",
    "General Mariano Alvarez",
    "Payatas",
    "San Andres",
    "Santa Cruz",
    "San Juan",
    "Poblacion",
    "Santamesa",
    "Bagong Silangan",
    "Putatan",
    "Western Bicutan",
    "Banco Filipino International Village",
    "Paco",
    "Malate",
    "Pandacan",
    "San Isidro",
    "San Antonio",
    "Pateros",
    "Tatalon",
    "Sucat",
    "Don Bosco",
    "Lower Bicutan",
    "Bignay",
    "Bagumbayan",
    "Upper Bicutan",
    "Marikina Heights",
    "Central Signal Village",
    "Bayanan",
    "Karuhatan",
    "Bel-Air",
    "Santo Niño",
    "Pansol",
    "Baclaran",
    "West Rembo",
    "Bagong Pag-Asa",
    "Pinyahan"
];

function populateSelect(selectId, options) {
    const selectElement = document.getElementById(selectId);

    options.forEach(option => {
        const optionElement = document.createElement("option");
        optionElement.value = option;
        optionElement.text = option;
        selectElement.add(optionElement);
    });
}

populateSelect("suffixMenu", suffixes);
populateSelect("courseMenu", courses);
populateSelect("cityMenu", cities);

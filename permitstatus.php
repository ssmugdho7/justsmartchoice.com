<?php
$company="Just Smart Choice Contractors";
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Permit & Inspection Lookup | Just Smart Choice</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
margin:0;
font-family:'Poppins', Arial;
background:#f6f8f7;
}

.portal-box{
max-width:700px;
margin:60px auto;
background:#fff;
padding:35px;
border-radius:12px;
box-shadow:0 6px 20px rgba(0,0,0,0.08);
text-align:center;
}

.portal-box h2{
font-size:28px;
margin-bottom:10px;
}

.portal-box p{
color:#666;
margin-bottom:20px;
}

select{
width:100%;
padding:14px;
margin:10px 0;
border-radius:6px;
border:1px solid #ccc;
font-size:15px;
}

button{
width:100%;
padding:16px;
margin-top:15px;
border:none;
border-radius:8px;
font-size:17px;
cursor:pointer;
background:#1fa463;
color:#fff;
transition:.3s;
}

button:hover{
background:#188a52;
}
</style>

</head>

<body>

<?php include __DIR__ . '/sections-library/header.php'; ?>

<div class="container">

<div class="portal-box">

<h2>Permit / Inspection Lookup</h2>
<p>Select your county and city</p>

<select id="county" onchange="updateCities()">
<option value="">Select County</option>

<!-- ALL 67 COUNTIES -->
<option>Alachua County</option>
<option>Baker County</option>
<option>Bay County</option>
<option>Bradford County</option>
<option>Brevard County</option>
<option>Broward County</option>
<option>Calhoun County</option>
<option>Charlotte County</option>
<option>Citrus County</option>
<option>Clay County</option>
<option>Collier County</option>
<option>Columbia County</option>
<option>DeSoto County</option>
<option>Dixie County</option>
<option>Duval County</option>
<option>Escambia County</option>
<option>Flagler County</option>
<option>Franklin County</option>
<option>Gadsden County</option>
<option>Gilchrist County</option>
<option>Glades County</option>
<option>Gulf County</option>
<option>Hamilton County</option>
<option>Hardee County</option>
<option>Hendry County</option>
<option>Hernando County</option>
<option>Highlands County</option>
<option>Hillsborough County</option>
<option>Holmes County</option>
<option>Indian River County</option>
<option>Jackson County</option>
<option>Jefferson County</option>
<option>Lafayette County</option>
<option>Lake County</option>
<option>Lee County</option>
<option>Leon County</option>
<option>Levy County</option>
<option>Liberty County</option>
<option>Madison County</option>
<option>Manatee County</option>
<option>Marion County</option>
<option>Martin County</option>
<option>Miami-Dade County</option>
<option>Monroe County</option>
<option>Nassau County</option>
<option>Okaloosa County</option>
<option>Okeechobee County</option>
<option>Orange County</option>
<option>Osceola County</option>
<option>Palm Beach County</option>
<option>Pasco County</option>
<option>Pinellas County</option>
<option>Polk County</option>
<option>Putnam County</option>
<option>Santa Rosa County</option>
<option>Sarasota County</option>
<option>Seminole County</option>
<option>St. Johns County</option>
<option>St. Lucie County</option>
<option>Sumter County</option>
<option>Suwannee County</option>
<option>Taylor County</option>
<option>Union County</option>
<option>Volusia County</option>
<option>Wakulla County</option>
<option>Walton County</option>
<option>Washington County</option>

</select>

<select id="city">
<option>Select City</option>
</select>

<button onclick="goPortal()">Check Permit / Inspection</button>

</div>

</div>

<?php include __DIR__ . '/sections-library/footer.php'; ?>

<script>

// COUNTY LINKS
const counties = {

"Alachua County":"https://aca.alachuacounty.us",
"Baker County":"https://www.bakercountyfl.org",
"Bay County":"https://aca.baycountyfl.gov",
"Bradford County":"https://www.bradfordcountyfl.gov",
"Brevard County":"https://aca-prod.accela.com/BREVARD",
"Broward County":"https://aca-prod.accela.com/BROWARD",
"Calhoun County":"https://www.calhouncountygov.com",
"Charlotte County":"https://aca.charlottecountyfl.gov",
"Citrus County":"https://aca.citrusbocc.com",
"Clay County":"https://aca.claycountygov.com",
"Collier County":"https://aca.colliergov.net",
"Columbia County":"https://www.columbiacountyfla.com",
"DeSoto County":"https://www.desotobocc.com",
"Dixie County":"https://www.dixiecounty.us",
"Duval County":"https://aca.coj.net",
"Escambia County":"https://aca.escambiacountyfl.gov",
"Flagler County":"https://aca.flaglercounty.org",
"Franklin County":"https://www.franklincountyflorida.com",
"Gadsden County":"https://www.gadsdencountyfl.gov",
"Gilchrist County":"https://gilchrist.fl.us",
"Glades County":"https://www.myglades.com",
"Gulf County":"https://www.gulfcounty-fl.gov",
"Hamilton County":"https://hamiltoncountyfl.com",
"Hardee County":"https://www.hardeecounty.net",
"Hendry County":"https://aca.hendryfla.net",
"Hernando County":"https://pvweb.hernandopa-fl.us/",
"Highlands County":"https://aca.highlandsfl.gov",
"Hillsborough County":"https://aca-prod.accela.com/hcfl",
"Holmes County":"https://holmescountyfl.org",
"Indian River County":"https://aca.indianriver.gov",
"Jackson County":"https://www.jacksoncountyfl.gov",
"Jefferson County":"https://www.jeffersoncountyfl.gov",
"Lafayette County":"https://lafayettecountyfl.com",
"Lake County":"https://c.lakecountyfl.gov/offices/building_services/permit_activity_reports/permit_search_by_address.aspx",
"Lee County":"https://aca.leegov.com",
"Leon County":"https://aca.leoncountyfl.gov",
"Levy County":"https://www.levycounty.org",
"Liberty County":"https://www.libertycountyfl.org",
"Madison County":"https://madisoncountyfl.com",
"Manatee County":"https://aca.mymanatee.org",
"Marion County":"https://selfservice.marionfl.org/energov_prod/selfservice#/search",
"Martin County":"https://aca.martin.fl.us",
"Miami-Dade County":"https://aca.miamidade.gov",
"Monroe County":"https://aca.monroecounty-fl.gov",
"Nassau County":"https://aca.nassaucountyfl.com",
"Okaloosa County":"https://aca.okaloosafl.com",
"Okeechobee County":"https://www.co.okeechobee.fl.us",
"Orange County":"https://fasttrack.ocfl.net/OnlineServices/Inspections.aspx?filter=Search",
"Osceola County":"https://permits.osceola.org",
"Palm Beach County":"https://aca.pbcgov.org",
"Pasco County":"https://aca-prod.accela.com/PASCO",
"Pinellas County":"https://aca-prod.accela.com/PINELLAS/Cap/CapHome.aspx?module=Building&TabName=Building",
"Polk County":"https://inspections.polk-county.net/",
"Putnam County":"https://aca.putnam-fl.com",
"Santa Rosa County":"https://aca.santarosa.fl.gov",
"Sarasota County":"https://aca.scgov.net",
"Seminole County":"https://semc-egov.aspgov.com/Click2GovBP/selectpermit.html",
"St. Johns County":"https://aca.sjcfl.us",
"St. Lucie County":"https://aca.stlucieco.gov",
"Sumter County":"https://sumtercountyfl.gov/131/Permit-Application",
"Suwannee County":"https://www.suwcounty.org",
"Taylor County":"https://www.taylorcountygov.com",
"Union County":"https://union.floridapa.com",
"Volusia County":"https://connectlivepermits.org/citizenportal/app/public-search",
"Wakulla County":"https://www.mywakulla.com",
"Walton County":"https://aca.waltoncountyfl.com",
"Washington County":"https://www.washingtonfl.com"

};

// CITY PORTALS
const cityLinks = {
"Orlando":"https://cityoforlandofl-permits.myrelayview.com/",
"Tampa":"https://aca-prod.accela.com/TAMPA",
"Daytona Beach":"https://daytonabeach.ims16.com/ims/Find3?cat=Permits"
};

// CITY DROPDOWN (optional basic mapping)
const countyCities = {
"Orange County":["Orlando","Winter Park","Apopka","Ocoee"],
"Hillsborough County":["Tampa"],
"Volusia County":["Daytona Beach"]
};

function updateCities(){
let county=document.getElementById("county").value;
let city=document.getElementById("city");

city.innerHTML="<option>Select City</option>";

if(countyCities[county]){
countyCities[county].forEach(c=>{
let opt=document.createElement("option");
opt.text=c;
city.add(opt);
});
}
}

function goPortal(){
let county=document.getElementById("county").value;
let city=document.getElementById("city").value;

if(!county){
alert("Please select county");
return;
}

// City priority
if(cityLinks[city]){
window.open(cityLinks[city],"_blank");
return;
}

// County fallback
window.open(counties[county],"_blank");
}

</script>

</body>
</html>
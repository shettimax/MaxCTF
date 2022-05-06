$ip = $_SERVER['REMOTE_ADDR']; // This will contain the ip of the request

// You can use a more sophisticated method to retrieve the content of a webpage with php using a library or something
// We will retrieve quickly with the file_get_contents
$dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

var_dump($dataArray);

// outputs something like (obviously with the data of your IP) :

// geoplugin_countryCode => "DE",
// geoplugin_countryName => "Germany"
// geoplugin_continentCode => "EU"

echo "Hello visitor from: ".$dataArray["geoplugin_countryName"];
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$query = isset($_GET['country']) ? $_GET['country'] : '';
$query2 = isset($_GET['lookup']) ? $_GET['lookup'] : '';

if ($query2 == 'cities') {
    $stmt = $conn->prepare("SELECT cities.name, cities.district, cities.population 
                            FROM cities 
                            INNER JOIN countries ON countries.code = cities.country_code 
                            WHERE countries.name LIKE :country");
    $stmt->execute(['country' => '%' . $query . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>District</th>
            <th>Population</th>
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name'] !== null ? $row['name'] : 'N/A') ?></td>
                <td><?= htmlspecialchars($row['district'] !== null ? $row['district'] : 'N/A') ?></td>
                <td><?= htmlspecialchars($row['population'] !== null ? $row['population'] : 'N/A') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
} else {
    if ($query == '') {
        $stmt = $conn->query("SELECT * FROM countries");
    } else {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => '%' . $query . '%']);
    }
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['continent']) ?></td>
                <td><?= htmlspecialchars($row['independence_year'] !== null ? $row['independence_year'] : 'N/A') ?></td>
                <td><?= htmlspecialchars($row['head_of_state'] !== null ? $row['head_of_state'] : 'N/A') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
}
?>


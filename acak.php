<?php

function generate_combinations($word) {
    // Buat semua kombinasi huruf besar dan kecil
    $combinations = [];
    $length = strlen($word);
    $max = 1 << $length;

    for ($i = 0; $i < $max; $i++) {
        $combination = '';
        for ($j = 0; $j < $length; $j++) {
            if (($i >> $j) & 1) {
                $combination .= strtoupper($word[$j]);
            } else {
                $combination .= strtolower($word[$j]);
            }
        }
        $combinations[] = $combination . '@gmail.com';
    }

    return $combinations;
}

function save_to_file($combinations, $filename) {
    $file = fopen($filename, 'w');
    foreach ($combinations as $combo) {
        fwrite($file, $combo . "\n");
    }
    fclose($file);
    return realpath($filename); // Mengembalikan path lengkap dari file yang disimpan
}

if (php_sapi_name() == "cli") {
    // Eksekusi via CMD dengan input pengguna setelah script dijalankan
    echo "Masukkan kata yang ingin diacak: ";
    $word = trim(fgets(STDIN));

    $combinations = generate_combinations($word);
    $filename = $word . "_combinations.txt";
    $filePath = save_to_file($combinations, $filename);
    echo "Generated " . count($combinations) . " combinations and saved to " . $filename . "\n";
    echo "File disimpan di: " . $filePath . "\n";
} else {
    // Eksekusi via Web (browser)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $word = $_POST['word'];
        $combinations = generate_combinations($word);
        $filename = $word . "_combinations.txt";
        $filePath = save_to_file($combinations, $filename);
        echo "Generated " . count($combinations) . " combinations and saved to " . $filename . "<br>";
        echo "File disimpan di: " . $filePath;
    }
}

?>

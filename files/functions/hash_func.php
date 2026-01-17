<?php

function createHash(string $password): string
{
    $saltSize = 24;
    $hashSize = 24;
    $iterations = 100000;

    // Generate random salt
    $salt = random_bytes($saltSize);

    // Derive hash (PBKDF2)
    // IMPORTANT: Default .NET Rfc2898DeriveBytes uses SHA1 unless specified
    $hash = hash_pbkdf2(
        'sha1',        // match .NET default
        $password,
        $salt,
        $iterations,
        $hashSize,
        true           // raw binary output
    );

    // Combine salt + hash
    $container = $salt . $hash;

    // Return Base64
    return base64_encode($container);
}

function verifyHash($password, $storedBase64): bool
{
    $saltSize = 24;
    $hashSize = 24;
    $iterations = 100000;
	
	$password = (string)$password;
	$storedBase64 = (string)$storedBase64;
	
	if(!$storedBase64) {
		return false;
	}

    // Decode the stored Base64 string
    $container = base64_decode($storedBase64, true);
    if ($container === false || strlen($container) !== ($saltSize + $hashSize)) {
        return false;
    }

    // Extract salt and stored hash
    $salt = substr($container, 0, $saltSize);
    $storedHash = substr($container, $saltSize, $hashSize);

    // Recompute hash using the provided password
    $computedHash = hash_pbkdf2(
        'sha1',       // match .NET default
        $password,
        $salt,
        $iterations,
        $hashSize,
        true          // raw binary output
    );

    // Timing-attack-safe comparison
    return hash_equals($storedHash, $computedHash);
}

?>
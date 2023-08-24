<?php

namespace BitterByter\JWT;

use BitterByter\JWT\Traits\ToolBox;
use BitterByter\JWT\Exceptions\InvalidTokenException;
use Carbon\Carbon;

/**
 * JWT.
 *
 * Algorithm : HS256.
 */
class JWT
{
    use ToolBox;

    /**
     * JWT Headers.
     */
    private static $headers = [
        'alg' => 'HS256',
        'type' => 'JWT'
    ];

    /**
     * Signature hashing algorithm.
     */
    private static $algo = 'sha256';

    /**
     * Creates a JWT token.
     *
     * @param array $payload The data to sign.
     * @param string $secret The 256 bit secret key.
     *
     * @return string
     */
    public static function sign(array $payload, string $secret): string
    {
        $data = self::dotUp(self::$headers, $payload);

        // Remove padding ('=') from data.
        $data = str_replace('=', '', $data);

        $secret = base64_encode($secret);

        $signature = hash_hmac(self::$algo, $data, $secret);

        return self::dotUp($data, $signature);
    }

    /**
     * Verifies a JWT token.
     *
     * @param string $token The token to verify.
     * @param string $secret The 256 bit secret key.
     *
     * @return array
     *
     * @throws InvalidTokenException When the `$token` is invalid.
     */
    public static function verify(string $token, string $secret): array
    {
        [$tokenHeader, $tokenPayload, $tokenSignature] = explode('.', $token);

        $tokenData = $tokenHeader . '.' . $tokenPayload;

        $secret = base64_encode($secret);

        $signature = hash_hmac(self::$algo, $tokenData, $secret);

        $isEqual = hash_equals($signature, $tokenSignature);

        if ($isEqual) {
            $tokenPayload = self::decode($tokenPayload);

            // Validate `exp` claim.
            if (isset($tokenPayload->exp)) {
                if (Carbon::now()->timestamp > $tokenPayload->exp) {
                    throw new InvalidTokenException('Token expired');
                }
            }

            return $tokenPayload;
        }

        throw new InvalidTokenException;
    }
}

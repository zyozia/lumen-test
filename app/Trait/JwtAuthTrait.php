<?php

namespace App\Trait;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * @method integer|string getKey()
 */
trait JwtAuthTrait
{
    /**
     * Get key
     *
     * @return string
     */
    protected static function getJwtKey(): string
    {
        return (string)config('app.key', '123');
    }

    /**
     * Generate Payload
     *
     * @return array
     */
    protected function getJwtPayload(): array
    {
        return [
            'iss' => $this->getKey(),
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + (60 * 60 * 6),
        ];
    }

    /**
     * Generate jwt token
     *
     * @return string
     */
    public function generateToken(): string
    {
        return JWT::encode($this->getJwtPayload(), self::getJwtKey(),  'HS256');
    }

    /**
     * Decode Token
     *
     * @param string $jwt
     *
     * @return bool|object
     */
    public static function decode($jwt)
    {
        try {
            $response = JWT::decode($jwt, new Key(self::getJwtKey(), 'HS256'));
            if ($response->exp < time()) {
                $response = false;
            }
        } catch (\Exception $e) {
            $response = false;
        }
        return $response;
    }

    /**
     * Get user by token
     *
     * @param $jwt
     *
     * @return ?static
     */
    public static function getByToken($jwt): ?static
    {
        if ($payload = self::decode($jwt)) {
            return static::find($payload->iss);
        }
        return null;
    }
}

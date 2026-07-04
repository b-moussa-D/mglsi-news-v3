<?php
class TokenGuard {
    public static function verifierAdmin(PDO $db, string $jeton): void {
        $tokenModel = new Token($db);
        $t = $tokenModel->estValide($jeton);
        if (!$t || $t['role'] !== 'administrateur') {
            throw new SoapFault('Server', 'Jeton invalide ou droits insuffisants.');
        }
    }
}
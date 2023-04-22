<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class PasswordTransformer implements DataTransformerInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function transform($value)
    {
        // La transformation de la valeur du mot de passe n'est pas nécessaire ici.
        // Nous laissons simplement le champ tel qu'il est.
        return $value;
    }

    public function reverseTransform($value)
    {
        // Si le champ de mot de passe n'a pas été rempli, nous ne changeons pas la valeur actuelle du mot de passe.
        if (empty($value)) {
            return null;
        }

        // Encodage du nouveau mot de passe.
        $encodedPassword = $this->encoder->encodePassword(new User(), $value);

        return $encodedPassword;
    }
}

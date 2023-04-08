<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Question;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Classe de Voter qui s'occupe des Question
 */
class QuestionVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    /**
     * Ce voter doit-il voter pour l'attribut demandé (l'action) et l'objet demandé (entité)
     * Si oui, Symfony appelera automatiquement la méthode voteOnAttribute() plus bas
     * avec les mêmes $attribute et $subject !
     * 
     * Ce Voter va s'occuper de 
     * - edit question
     * - answer validate
     */
    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, ['edit', 'answer_validate'])) {
            return false;
        }

        // only vote on `Question` objects
        if (!$subject instanceof Question) {
            return false;
        }

        return true;
    }

    /**
     * Le Voter est exécuté pour $attribute (par ex. 'edit') et $subject (par ex. $question)
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        // on récupère l'utiisateur
        $user = $token->getUser();

        // s'il n'est pas connecté
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // optionnel : (on pourrait tout coder avec $subject)
        // ajout d'un DocBlock pour clarifier notre code (le sujet reçu est une question)
        // et opur avoir l'auto-complétion dans VS Code
        /** @var Question $question */
        $question = $subject;

        // on doit retourner true ou false selon ce que l'on veut autoriser ou non
        // en fonction de la valeur de $attribute
        // @see https://www.php.net/manual/fr/control-structures.switch.php
        switch ($attribute) {
            // dans le cas où $attribute vaut 'edit'
            // if ($attribute == 'edit')
            case 'edit':
                // traitons tous les cas ou on autorise

                // rôle modérateur ?
                if ($this->security->isGranted('ROLE_MODERATOR')) {
                    return true;
                }

                // auteur de la question ?
                if ($user === $question->getUser()) {
                    return true;
                }
                // sort du switch (après l'accolade)
                break;
            
            // validation de la bonne réponse à une question
            case 'answer_validate':
                // auteur de la question ?
                if ($user === $question->getUser()) {
                    return true;
                }
                break;
            
            // si aucun des cas n'est trouvé
            // (else)
            default:
                break;
        }

        // par défaut, le Voter n'autorise pas
        return false;
    }
}
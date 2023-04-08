# FAQ O'clock

Clairement *Stackoverflow* c'est pas si terrible :trollface: alors on s'est dit qu'il fallait réinventer la roue :grinning:

Mais on n'a pas fini le projet... sinon ça serait trop facile :upside_down_face:

Voici donc un sacré projet, pas tout à fait terminé. Il a pour but de proposer un site où les utilisateurs peuvent poser des questions et d'autres utilisateurs y répondent. Comme pour Stackoverflow, celui qui a posé la question peut voter pour la meilleure réponse.

Il y a d'autres fonctionnalités mises en place qu'on vous laisse découvrir.

**Avant toutes choses vous devrez donc installer et apprivoiser ce projet.**

> Installez les dépendances, configurez vos variables d'environnement, chargez les fixtures !

# Challenge

On a vu qu'on pouvait attribuer des rôles à des utilisateurs. Grâce aux rôles, on peut définir des droits d'accès à certaines routes. On peut également, dans un contrôleur, n'autoriser l'accès que pour certains rôles. Mais que faire quand on souhaite **autoriser l'accès à une entité selon l'identité de l'utilisateur** ?

L'`access_control` ne le permet pas. Comment pourrait-on, par exemple, **permettre aux utilisateurs d'éditer leurs questions mais pas celles des autres** ?

Ou encore, **ne permettre qu'à l'auteur de la question de valider la bonne réponse**.

# Les voters !

Sur cette documentation, vous trouverez tout le nécessaire pour créer des voters : https://symfony.com/doc/current/security/voters.html

## Objectifs

### Analyse/code sans Voter

- Analyser le code de AnswerController::validate() pour comprendre comment gérer les droits sur une entité pour le User connecté.
- Coder le même genre de chose pour QuestionController::edit(). Seul l'auteur de la question, un modérateur ou un administrateur peut modifier une question.

### 1. Voter : Modifier une question

Créer un voter qui autorise de modifier une question si l'utilisateur qui tente de le faire est :

- l'auteur de la question,
- un modérateur ou un administrateur.

### 2. Voter : Valider la bonne réponse

Changer les règles de validation de la bonne réponse. Les personnes suivantes sont autorisées à valider la bonne réponse : 

- l'auteur de la question,
- un modérateur ou un administrateur.

Peut-on utiliser le voter créé précédemment ? (Voter sur Question).

## Bonus

- Masquer les boutons de modification et de validation de la bonne réponses côté Twig, après avoir codé ces features dans le Voter.

:tada:

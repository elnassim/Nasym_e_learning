#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define MAX_VILLE 50

typedef struct {
    int num;
    char depart[MAX_VILLE];
    char arrivee[MAX_VILLE];
    char date[11]; 
    float prix;
    int dispo; 
} Vol;

typedef struct Node {
    Vol v;
    struct Node *suivant;
} Node;

Node* ajouterTrie(Node *tete, Vol nv) {
    Node *n = malloc(sizeof(Node));
    if (!n) {
        perror("Erreur d'allocation mémoire");
        exit(EXIT_FAILURE);
    }
    n->v = nv;

    if (tete == NULL || nv.prix < tete->v.prix) {
        n->suivant = tete;
        return n;
    }

    Node *actuel = tete;
    while (actuel->suivant && actuel->suivant->v.prix < nv.prix) {
        actuel = actuel->suivant;
    }
    n->suivant = actuel->suivant;
    actuel->suivant = n;
    return tete;
}

void rechercherDispo(Node *tete, char *dep, char *arr, char *date) {
    Node *actuel = tete;
    while (actuel) {
        if (actuel->v.dispo &&
            !strcmp(actuel->v.depart, dep) &&
            !strcmp(actuel->v.arrivee, arr) &&
            !strcmp(actuel->v.date, date)) {
            printf("Vol n°%d trouvé : %s -> %s le %s (%.2f€)\n",
                   actuel->v.num, actuel->v.depart, actuel->v.arrivee, actuel->v.date, actuel->v.prix);
        }
        actuel = actuel->suivant;
    }
}

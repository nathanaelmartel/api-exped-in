# api-exped-in
Wraper pour l'API Exped'In

## Authentification

Vous aurez besoins d'une clée ainsi que de l'URL de l'API. La clée doit être transmise dans un header bearer.

## Commandes clients

### Récupération de toutes les commandes
GET /order

### Récupération d'une commande
GET /order/{id}

## Commandes fournisseurs

### Récupétation des toutes les commandes fournisseurs
GET /orderSupplier

### Récupétation des toutes les commandes fournisseurs
GET /orderSupplier/{id}

### Nouvelle commande fournisseurs
POST /orderSupplier/new

## Produits

### Récupération de tous les produits
GET /product

response:
{
    'error': 0,
    'length': 10,
    'data': [
        {
            'id': ''
            'name': ''
            'ean': ''
            'sku': ''
            'reference': ''
            'dimension': {
                'width':
                'height':
                'depth':
            }
            'poids':
            'stock':
        },
        …
    ]
}

### Récupération d'un produit
GET /product/{id}

response:
{
    'error': 0,
    'data': {
            'id': ''
            'name': ''
            'ean': ''
            'sku': ''
            'reference': ''
            'dimension': {
                'width':
                'height':
                'depth':
            }
            'poids':
            'stock':
        }
}

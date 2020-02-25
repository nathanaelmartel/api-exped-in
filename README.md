# API Exped'In
Wraper php pour l'API Exped'In et documentation.

## Authentification

Vous aurez besoins d'une clée ainsi que de l'URL de l'API. La clée doit être transmise dans un header bearer.

```php
<?php
require_once 'ExpedInWrapper.php';
$api = new \ExpedIn\ExpedInWrapper([
    'key' => 'your_key',
    'url' => 'api_url',
]);
```

## Commandes clients

### Récupération de toutes les commandes client
GET /order

```php
<?php
$orders = $api->getOrders();
```

response:
```javascript
[{
    'error': 0,
    'length': 10,
    'data': [
        {
            'uid': ''
            'reference': ''
            'status': ''
            'shipping_address': {}
            'customer': ''
            'products':[
                {
                    "uid": "",
                    "quantity": 1
                }
            ]
        },
        …
    ]
}]
```

### Récupération d'une commande client
GET /order/{uid}

```php
<?php
$orders = $api->getOrder('order_uid');
```

response:
```javascript
[{
    'error': 0,
    'data': {
            'uid': ''
            'reference': ''
            'status': ''
            'shipping_address': {}
            'customer': ''
            'products':[
                {
                    "uid": "",
                    "quantity": 1
                }
            ]
    }
}]
```

### Création d'une commande client
GET /order/{uid}

```php
<?php
$order_data = [];
$orders = $api->setOrder($order_data);
```

post data:
```javascript
{
    'id_order': 1234, // your order ID
    'reference': '', // your unique reference
    'supplier_name': '',
    'supplier_reference': '',
    'products': [
        {
            'sku': '',
            'reference': '',
            'name': '',
            'ean13': '',
            'quantity': 10
        },
        …
    ]
}
```

response:
```javascript
[{
    'error': 0,
    'data': {
            'uid': ''
            'reference': ''
            'status': ''
            'shipping_address': {}
            'customer': ''
            'products':[
                {
                    "uid": "",
                    "quantity": 1
                }
            ]
    }
}]
```

## Commandes fournisseurs

### Récupétation des toutes les commandes fournisseurs
GET /orderSupplier

```php
<?php
$orders = $api->getOrderssupplier();
```

response:
```javascript
[{
    'error': 0,
    'length': 10
    'data': [
        {
            'uid': ''
            'id_order': ''
            'reference': ''
            'status': ''
            'shipping_address': {}
            'customer': ''
            'products':[
                {
                    "uid": "",
                    "quantity_expected": 1
                    "quantity_received": null
                },
                …
            ]
        },
        …
    ]
}]
```

### Récupétation d'une commande fournisseur
GET /orderSupplier/{uid}

```php
<?php
$orders = $api->getOrdersupplier('order_supplier_uid');
```

response:
```javascript
[{
    'error': 0,
    'data': {
            'uid': '',
            'id_order': '',
            'reference': '',
            'status': '',
            'supplier_name': '',
            'supplier_reference': '',
            'date_add': '',
            'products':[
                {
                    "uid": "",
                    "quantity_expected": 1
                    "quantity_received": null
                }
            ]
    }
}]
```

### Nouvelle commande fournisseurs
POST /orderSupplier/new

```php
<?php
$new_ordersupplier = [
    'id_order' => time(), // your order ID
    'reference' => 'MYREF'.time(), // your unique reference
    'supplier_name' => 'fournisseur',
    'supplier_reference' => 'REF_FOUR',
    'products' => [
        [
            'sku' => '1234567890123',
            'reference' => 'REFPRODUCT',
            'name' => 'Produit alpha',
            'ean13' => '1234567890123',
            'quantity' => 1,
        ],
    ],
];
$result = $api->setOrdersupplier($new_ordersupplier);
```

Les produits sont identifiés par leur sku. Si le sku n'est pas trouvé, le produit est créé.

post data:
```javascript
{
    'id_order': 1234, // your order ID
    'reference': '', // your unique reference
    'supplier_name': '',
    'supplier_reference': '',
    'products': [
        {
            'sku': '',
            'reference': '',
            'name': '',
            'ean13': '',
            'quantity': 10
        },
        …
    ]
}
```


response:
```javascript
[{
    'error': 0,
    'data': {
            'uid': ''
            'id_order': ''
            'reference': ''
            'status': ''
            'shipping_address': {}
            'customer': ''
            'products':[
                {
                    "uid": "",
                    "quantity": 1
                }
            ]
    }
}]
```

## Produits

### Récupération de tous les produits
GET /product

```php
<?php
$products = $api->getProducts();
```

response:
```javascript
[{
    'error': 0,
    'length': 10,
    'data': [
        {
            'uid': ''
            'name': ''
            'ean13': ''
            'sku': ''
            'reference': ''
            'width':
            'height':
            'depth':
            'weight':
            'stock':
        },
        …
    ]
}]
```

### Récupération d'un produit
GET /product/{uid}

```php
<?php
$product = $api->getProduct('product_uid');
```

response:
```javascript
[{
    'error': 0,
    'data': {
            'uid': ''
            'name': ''
            'ean13': ''
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
}]
```

### Création d'un produit
Les produits doivent être créé en faisant une commande fournisseur.

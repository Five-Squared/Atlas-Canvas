# Atlas-Canvas
Script to quickly create boilerplate classes for new Atlas models.

### Using Canvas ###
The atlas repo ships with a script to quickly create boilerplate classes for new models.
```
php vendor/fivesqrd/atlas/scripts/Canvas.php User
php vendor/fivesqrd/atlas/scripts/Canvas.php Customer
php vendor/fivesqrd/atlas/scripts/Canvas.php Contact
```

Edit the Mapper class and update the table details 
```
<?php
namespace Application\Model\User;

class Mapper extends \Atlas\Model\Mapper
{
    protected $_alias = 'u';

    protected $_table = 'users';

    protected $_key = 'id';

    protected $_map = array(
        '_id'        => 'id',
        '_email'     => 'email',
        '_password   => 'password',
        '_lastLogin' => 'last_login'
    );

    protected $_readOnly = array('id');
}
```

Edit the Entity class and create the mapped properties 
```
<?php
namespace Application\Model\User;

class Entity extends \Atlas\Model\Entity
{
    protected $_id;
    
    protected $_email;
    
    protected $_password;
    
    protected $_lastLogin;
}
```

### File Structure ###
Below is an example what a project with 3 models might look like. For more details, have a look
at these [examples](https://github.com/Five-Squared/Atlas/tree/master/examples/Application/)

```
|- Model
   |-- User.php
   |-- User
       |-- Entity.php
       |-- Mapper.php
       |-- Collection.php
       |-- Query.php
       |-- Named.php
       |-- Relation.php
   |-- Customer.php
   |-- Customer
       ...
   |-- Content.php
   |-- Contact
       ...
```

## Install and Setup ##

### Install ###
Via composer
``` 
cd /myproject
php composer.phar require fivesqrd/atlas-canvas
```

### Configure ###
Configure canvas to remember project specific settings, such as path to model classes and namespace:
```
cd /myproject
mkdir .canvas
cp vendor/fivesqrd/atlas-canvas/scripts/.canvas/config.php .canvas/config.php
vi .canvas/config.php
```

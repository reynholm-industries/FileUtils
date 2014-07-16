File Utils
=============
[![Build Status](https://travis-ci.org/reynholm-industries/FileUtils.svg?branch=master)](https://travis-ci.org/reynholm-industries/FileUtils)

Multiple tools for working with files

##Examples:

###ArrayConversor
```php5
<?php
$csvFileName = $arrayConversor->toCsv($inputArray, $destinationFile);
$xlsFileName = $arrayConversor->toXls($inputArray, $destinationFile);
```

###CsvFileConversor
```php5
<?php
$array = $this->csvConversor->toArray($csvFile, $rowsToSkip, $useFirstRowAsKeys, $delimiterChar);
```


###XlsFileConversor
```php5
<?php
$array = $this->xlsConversor->toArray($xlsFile);
```

Check the unit tests folder for more examples.

To run the tests use the
```shell
command vendor\bin\codecept run unit
```

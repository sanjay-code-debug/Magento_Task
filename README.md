



Magento Task Concept Wise
--------------------------






Di(Dependency Injection)
------------------------
    |---All the Area where di.xml can declare
    |                     |---global
    |                     |---adminhtml
    |                     |---frontend
    |                     |---web_api_rest
    |                     |---web_api_soap
    |                     |---graphql
    |                     |---crontab
    |
    |
    |---Task Based on Plugin
    |
    |---Task Based on Events and Oberser
    |   --------------------------------
    |    |             - Based on Configuration(selected value need to show) - Order Status need to set based on configuration 
    |    |             - 
    |    |
    |    |
    |    |---------Some of the Events
    |              ------------------
    |                           |------ Sales
    |                                      |-------after_place_order
    |
    |
    |
    |
    |----Task Based on Preference
         ------------------------
                   - Override Particular Method (change the logic of that method only )
   
 
 
 

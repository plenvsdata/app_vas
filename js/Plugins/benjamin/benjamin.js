(function( $ ) {
 
    $.fn.benjaminjs = function( options ) {
        
        var settings = $.extend( { currency: 'GBP' }, options );
        
        var currencies = new Array();
            currencies['AFN'] = ['','',2,'pre','؋'],
            currencies['ALL'] = ['','',2,'pre','Lek'],
            currencies['DZD'] = ['','',2,'post','Algerian Dinar'],
            currencies['AOA'] = ['','',2,'post','Angola, Kwanza'],
            currencies['ARS'] = ['.',',',2,'pre','$'],
            currencies['AMD'] = [',','.',2,'post','Armenian Dram'],
            currencies['AWG'] = [',','.',2,'pre','ƒ'],
            currencies['AUD'] = [' ','.',2,'pre','$'],
            currencies['AZN'] = ['','',2,'pre','ман'],
            currencies['BSD'] = [',','.',2,'pre','$'],
            currencies['BHD'] = [',','.',3,'post','Bahraini Dinar'],
            currencies['BDT'] = [',','.',2,'post','Bangladesh, Taka'],
            currencies['BBD'] = ['','',2,'pre','$'],
            currencies['BYN'] = ['','',0,'pre','Br'],
            currencies['BYR'] = ['','',0,'post','Belarussian Ruble'],
            currencies['BZD'] = [',','.',2,'pre','BZ$'],
            currencies['BMD'] = [',','.',2,'pre','$'],
            currencies['BTN'] = ['','',2,'post','Bhutan, Ngultrum'],
            currencies['BOB'] = [',','.',2,'pre','$b'],
            currencies['BAM'] = [',','.',2,'pre','KM'],
            currencies['BWP'] = [',','.',2,'pre','P'],
            currencies['BRL'] = ['.',',',2,'pre','R$'],
            currencies['BND'] = [',','.',2,'pre','$'],
            currencies['BGN'] = ['','',2,'pre','лв'],
            currencies['BIF'] = ['','',0,'post','Burundi Franc'],
            currencies['KHR'] = ['','',2,'pre','៛'],
            currencies['CAD'] = [',','.',2,'pre','$'],
            currencies['CVE'] = ['','',,'post','Cape Verde Escudo'],
            currencies['KYD'] = [',','.',2,'pre','$'],
            currencies['XPF'] = ['','',0,'post','CFP Franc'],
            currencies['CLP'] = ['.','',0,'pre','$'],
            currencies['CNY'] = [',','.',2,'pre','¥'],
            currencies['COP'] = ['.',',',2,'pre','$'],
            currencies['KMF'] = ['','',0,'post','Comoro Franc'],
            currencies['CRC'] = ['.',',',2,'pre','₡'],
            currencies['HRK'] = ['.',',',2,'pre','kn'],
            currencies['CUC'] = [',','.',2,'post','Cuban Convertible Peso'],
            currencies['CUP'] = [',','.',2,'pre','₱'],
            currencies['CYP'] = ['.',',',2,'post','Cyprus Pound'],
            currencies['CZK'] = ['.',',',2,'pre','Kč'],
            currencies['DKK'] = ['.',',',2,'pre','kr'],
            currencies['DJF'] = ['','',0,'post','Djibouti Franc'],
            currencies['DOP'] = [',','.',2,'pre','RD$'],
            currencies['XCD'] = [',','.',2,'pre','$'],
            currencies['EGP'] = [',','.',2,'pre','£'],
            currencies['SVC'] = [',','.',2,'pre','$'],
            currencies['ERN'] = ['','',2,'post','Eritrea, Nakfa'],
            currencies['ETB'] = ['','',2,'post','Ethiopian Birr'],
            currencies['ATS'] = [',','.',2,'pre','€'],
            currencies['BEF'] = [',','.',2,'pre','€'],
            currencies['DEM'] = [',','.',2,'pre','€'],
            currencies['EEK'] = [',','.',2,'pre','€'],
            currencies['ESP'] = [',','.',2,'pre','€'],
            currencies['EUR'] = [',','.',2,'pre','€'],
            currencies['FIM'] = [',','.',2,'pre','€'],
            currencies['FRF'] = [',','.',2,'pre','€'],
            currencies['GRD'] = [',','.',2,'pre','€'],
            currencies['IEP'] = [',','.',2,'pre','€'],
            currencies['ITL'] = [',','.',2,'pre','€'],
            currencies['LUF'] = [',','.',2,'pre','€'],
            currencies['NLG'] = [',','.',2,'pre','€'],
            currencies['PTE'] = [',','.',2,'pre','€'],
            currencies['FKP'] = ['','',2,'pre','£'],
            currencies['FJD'] = ['','',2,'pre','$'],
            currencies['CDF'] = ['','',2,'post','Franc Congolais'],
            currencies['XAF'] = ['','',,'post','Franc de la Communaute financi'],
            currencies['GMD'] = ['','',2,'post','Gambia, Dalasi'],
            currencies['GEL'] = ['','',2,'post','Georgia, Lari'],
            currencies['GHS'] = ['','',2,'pre','¢'],
            currencies['GHC'] = [',','.',2,'post','Ghana, Cedi'],
            currencies['GIP'] = [',','.',2,'pre','£'],
            currencies['GTQ'] = [',','.',2,'pre','Q'],
            currencies['GYD'] = ['','',2,'pre','$'],
            currencies['HTG'] = ['','',2,'post','Haiti, Gourde'],
            currencies['HNL'] = [',','.',2,'pre','L'],
            currencies['HKD'] = [',','.',2,'pre','$'],
            currencies['HUF'] = ['.','',0,'pre','Ft'],
            currencies['ISK'] = ['.','',0,'pre','kr'],
            currencies['INR'] = [',',',',2,'post','Indian Rupee'],
            currencies['IDR'] = ['.',',',2,'pre','Rp'],
            currencies['IRR'] = [',','.',2,'pre','﷼'],
            currencies['IQD'] = ['','',3,'post','Iraqi Dinar'],
            currencies['JMD'] = [',','.',2,'pre','J$'],
            currencies['JPY'] = [',','',0,'pre','¥'],
            currencies['JOD'] = [',','.',3,'post','Jordanian Dinar'],
            currencies['KZT'] = ['','',2,'pre','лв'],
            currencies['KES'] = [',','.',2,'post','Kenyan Shilling'],
            currencies['KWD'] = [',','.',3,'post','Kuwaiti Dinar'],
            currencies['KGS'] = ['','',2,'pre','лв'],
            currencies['LAK'] = ['','',2,'pre','₭'],
            currencies['LVL'] = [',','.',2,'post','Latvian Lats'],
            currencies['LBP'] = [' ','.',2,'pre','£'],
            currencies['LSL'] = ['','',2,'post','Lesotho, Loti'],
            currencies['LRD'] = ['','',2,'pre','$'],
            currencies['LYD'] = ['','',3,'post','Libyan Dinar'],
            currencies['LTL'] = [' ',',',2,'post','Lithuanian Litas'],
            currencies['MOP'] = ['','',2,'post','Macao, Pataca'],
            currencies['MKD'] = [',','.',2,'pre','ден'],
            currencies['MGA'] = ['','',0,'post','Malagasy Ariary'],
            currencies['MWK'] = ['','',2,'post','Malawi, Kwacha'],
            currencies['MYR'] = [',','.',2,'pre','RM'],
            currencies['MVR'] = ['','',2,'post','Maldives, Rufiyaa'],
            currencies['MTL'] = [',','.',2,'post','Maltese Lira'],
            currencies['MRO'] = ['','',2,'post','Mauritania, Ouguiya'],
            currencies['MUR'] = [',','.',2,'pre','₨'],
            currencies['MXN'] = [',','.',2,'pre','$'],
            currencies['MDL'] = ['','',2,'post','Moldovan Leu'],
            currencies['MNT'] = ['','',2,'pre','₮'],
            currencies['MAD'] = ['','',2,'post','Moroccan Dirham'],
            currencies['MZM'] = ['.',',',2,'post','Mozambique Metical'],
            currencies['MZN'] = ['','',0,'pre','MT'],
            currencies['MMK'] = ['','',2,'post','Myanmar, Kyat'],
            currencies['NAD'] = ['','',2,'pre','$'],
            currencies['NPR'] = [',','.',2,'pre','₨'],
            currencies['ANG'] = ['.',',',2,'pre','ƒ'],
            currencies['ILS'] = [',','.',2,'pre','₪'],
            currencies['TWD'] = ['','',2,'pre','NT$'],
            currencies['TRY'] = [',','.',2,'post','New Turkish Lira'],
            currencies['NZD'] = [',','.',2,'pre','$'],
            currencies['NIO'] = ['','',2,'pre','C$'],
            currencies['NGN'] = ['','',2,'pre','₦'],
            currencies['KPW'] = ['','',2,'pre','₩'],
            currencies['NOK'] = ['.',',',2,'pre','kr'],
            currencies['PKR'] = [',','.',2,'pre','₨'],
            currencies['PAB'] = ['','',2,'pre','B/.'],
            currencies['PGK'] = ['','',2,'post','Papua New Guinea, Kina'],
            currencies['PYG'] = ['','',0,'pre','Gs'],
            currencies['PEN'] = [',','.',2,'pre','S/.'],
            currencies['UYU'] = ['.',',',2,'pre','$U'],
            currencies['PHP'] = [',','.',2,'pre','₱'],
            currencies['PLN'] = [' ',',',2,'pre','zł'],
            currencies['GBP'] = [',','.',2,'pre','£'],
            currencies['QAR'] = ['','',2,'pre','﷼'],
            currencies['OMR'] = [',','.',3,'pre','﷼'],
            currencies['RON'] = ['.',',',2,'pre','lei'],
            currencies['ROL'] = ['.',',',2,'post','Romania, Old Leu'],
            currencies['RUB'] = ['.',',',2,'pre','₽'],
            currencies['RWF'] = ['','',0,'post','Rwanda Franc'],
            currencies['SAC'] = ['','',,'post','S. African Rand Commerc.'],
            currencies['SHP'] = ['','',2,'pre','£'],
            currencies['WST'] = ['','',2,'post','Samoa, Tala'],
            currencies['STD'] = ['','',2,'post','Sao Tome and Principe, Dobra'],
            currencies['SAR'] = [',','.',2,'pre','﷼'],
            currencies['CSD'] = ['','',2,'post','Serbian Dinar'],
            currencies['RSD'] = ['','',2,'pre','Дин.'],
            currencies['SCR'] = ['','',2,'pre','₨'],
            currencies['SLL'] = ['','',2,'post','Sierra Leone, Leone'],
            currencies['SGD'] = [',','.',2,'pre','$'],
            currencies['SKK'] = [' ',',',2,'post','Slovak Koruna'],
            currencies['SIT'] = ['.',',',2,'post','Slovenia, Tolar'],
            currencies['SBD'] = ['','',2,'pre','$'],
            currencies['SOS'] = ['','',2,'pre','S'],
            currencies['ZAR'] = [' ','.',2,'pre','R'],
            currencies['KRW'] = [',','',0,'pre','₩'],
            currencies['LKR'] = ['','',2,'pre','₨'],
            currencies['SDD'] = ['','',2,'post','Sudanese Dinar'],
            currencies['SRD'] = ['','',2,'pre','$'],
            currencies['SZL'] = [',',' ',2,'post','Swaziland, Lilangeni'],
            currencies['SEK'] = [' ',',',2,'pre','kr'],
            currencies['CHF'] = ['\'','.',2,'pre','CHF'],
            currencies['SYP'] = ['','',2,'pre','£'],
            currencies['TJS'] = ['','',,'post','Tajikistan, Somoni'],
            currencies['TZS'] = [',','.',2,'post','Tanzanian Shilling'],
            currencies['THB'] = [',','.',2,'pre','฿'],
            currencies['TOP'] = [',','.',2,'post','Tonga, Paanga'],
            currencies['TTD'] = ['','',2,'pre','TT$'],
            currencies['TND'] = ['','',3,'post','Tunisian Dinar'],
            currencies['TMM'] = ['','',2,'post','Turkmenistan Manat'],
            currencies['TMT'] = ['','',2,'post','Turkmenistani New Manat'],
            currencies['AED'] = [',','.',2,'post','UAE Dirham'],
            currencies['UGX'] = ['','',2,'post','Uganda Shilling'],
            currencies['UAH'] = [' ',',',2,'pre','₴'],
            currencies['CLF'] = ['','',2,'post','Unidad de Fomento'],
            currencies['USD'] = [',','.',2,'pre','$'],
            currencies['UZS'] = ['','',2,'pre','лв'],
            currencies['VUV'] = [',','',0,'post','Vanuatu, Vatu'],
            currencies['VEF'] = ['.',',',2,'pre','Bs'],
            currencies['VND'] = ['.','.',2,'pre','₫'],
            currencies['YER'] = ['','',2,'pre','﷼'],
            currencies['ZMK'] = ['','',2,'post','Zambia Kwacha'],
            currencies['ZMW'] = ['','',2,'post','Zambia Kwacha'],
            currencies['ZWD'] = [' ','.',2,'pre','Z$'];
 
        this.each(function() {
            var e = $(this),
                v = e.html(),
                o = e.attr('data-bjold'),
                n = e.attr('data-bjnew');
            
            if (!o) { o = settings.oldCurrency; } else { e.attr('data-bjold',n); }
            if (!n) { n = settings.newCurrency; } else { e.attr('data-bjnew',o); }
            
            var oldC = currencies[o],
                newC = currencies[n];
            
            if (oldC[0] !== undefined) { v = v.replace(oldC[0],''); }
            if (oldC[1] !== undefined) { v = v.replace(oldC[1],'.'); }
            v = v.replace(/[^0-9.]/, '');
            
            function fC(v, newC, oldC, e) {
                var vA = v.split('.'),
                    v1L = vA[0].toString().length;
                if (v1L >= 4) { 
                    var v1a = vA[0].slice(0,-3), 
                        v1b = vA[0].slice(-3), 
                        v1 = v1a+newC[0]+v1b;
                    v = v1+newC[1]+vA[1];
                } else { v = v.replace('.',newC[1]); }

                var output = (newC[3] == 'pre' ? newC[4]+v : v+newC[4]);

                e.html(output);
            }
            
            if (o != n) {
                var xurl = 'http://api.fixer.io/latest?base='+o+'&symbols='+n;
                $.getJSON(xurl, function(data){
                    var jsonContent = $(data), rate = jsonContent[0]['rates'][n];
                    if(rate) {  
                        rate = parseFloat(rate);
                        v = parseFloat(v);
                        v = v * rate;
                        v = (v).toFixed(newC[2]);
                        
                        fC(v, newC, oldC, e);
                   } else {
                        var xurl = 'http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency='+o+'&ToCurrency='+n,
                            yqlURL = [ "http://query.yahooapis.com/v1/public/yql", "?q=" + encodeURIComponent("select * from xml where url='" + xurl + "'"), "&format=xml&callback=?" ].join("");
                       
                        $.getJSON(yqlURL, function(data){
                            var jsonContent = $(data)[0].results, xml = $(jsonContent[0]), rate = xml.html();
                            if(rate && rate > 0) {  
                                rate = parseFloat(rate);
                                v = parseFloat(v);
                                v = v * rate;
                                v = (v).toFixed(newC[2]);

                                fC(v, newC, oldC, e);
                           } else { return; }
                        });
                   }
                });
            } else {
                fC(v, newC, oldC, e);
            }
        });
 
        return this;
 
    };
    
    $.fn.benjaminjs.defaults = {
        currency: 'GBP'
    };
 
}( jQuery ));
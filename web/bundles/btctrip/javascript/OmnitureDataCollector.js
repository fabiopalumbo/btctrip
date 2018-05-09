registerNameSpace("Common");Common.OmnitureDataCollector=function(options){var me=this;this.globalPaxCantInf=0;this.globalPaxCantCnn=0;this.globalPaxCantAdt=0;this.setList=function(number,value){data["list"+number]=value};this.getList=function(number){return data["list"+number]};this.setEVar=function(number,value){data["eVar"+number]=value};this.getEVar=function(number){return data["eVar"+number]};this.setProp=function(number,value){data["prop"+number]=value};this.setNamedVar=function(name,value){data[name]=value};this.getNamedVar=function(value){return data[value]};this.setEvent=function(number,product){if(product!=-1){dataEvents["event"+number]=product}else{dataEvents["event"+number]=-1}};this.setNamedEvent=function(value){dataEvents[value]=-1};this.setAsyncEvent=function(num,value){var omnitureDataCollectorAjax=new Common.OmnitureDataCollector();omnitureDataCollectorAjax.setEvent(num,value);omnitureDataCollectorAjax.beforeApply(s);s=omnitureDataCollectorAjax.applyData(s);omnitureDataCollectorAjax.afterApply(s);omnitureDataCollectorAjax.sendData(s)};this.fireEvent=function(event){var omnitureDataCollectorAjax=new Common.OmnitureDataCollector();if(event.name!=undefined){omnitureDataCollectorAjax.setNamedEvent(event.name)}if(event.eVar!=undefined&&event.value!=undefined){omnitureDataCollectorAjax.setNamedVar(event.eVar,event.value)}omnitureDataCollectorAjax.beforeApply(s);s=omnitureDataCollectorAjax.applyData(s);omnitureDataCollectorAjax.afterApply(s);omnitureDataCollectorAjax.sendData(s)};this.fireEvar=function(eVarId,eVarValue){var omnitureDataCollectorAjax=new Common.OmnitureDataCollector();var existOmnitureDataColletor=false;try{existOmnitureDataColletor=odc.isAviable()}catch(e){}if(existOmnitureDataColletor){omnitureDataCollectorAjax.beforeApply(s);s=odc.applyData(s);omnitureDataCollectorAjax.afterApply(s);omnitureDataCollectorAjax.setEVar(eVarId,eVarValue);omnitureDataCollectorAjax.sendData(s)}};this.isAviable=function(){if(typeof(s)!="object"){return false}else{return true}};this.beforeApply=function(omnitureObject){};this.applyData=function(omnitureObject){for(var prop in data){try{eval("omnitureObject."+prop+' = "'+data[prop]+'";')}catch(e){this.errMessages+=e+"\n"}}omnitureObject.events="";for(var event in dataEvents){try{if(omnitureObject.events==""){omnitureObject.events=event}else{omnitureObject.events+=","+event}}catch(e){this.errMessages+=e+"\n"}}return omnitureObject};this.sendData=function(omnitureObject){omnitureObject.t()};this.sendDataNoPageview=function(omnitureObject){omnitureObject.tl()};this.afterApply=function(omnitureObject){};this.submit=function(){if(this.isAviable()){this.beforeApply(s);s=this.applyData(s);this.afterApply(s)}s.t()};this.getErrors=function(){return this.errMessages};this.setAutomaticCountry=function(){var country="INC";if(this.getPaisVisita()==undefined&&!Common.Utils.Cookie.ReadCookie("s_eVar27")){var curDomain=document.domain;var foundCountry=curDomain.match(/\b(AR|BO|BR|CL|CO|CR|EC|SV|ES|GT|HN|MX|NI|PA|PY|PE|PR|DO|UY|US|VE|INC|decolar)\b/ig);if(foundCountry!=null&&foundCountry.length>0){country=foundCountry[0].toUpperCase();if(country=="DECOLAR"){country="BR"}if(foundCountry[0]=="co"&&foundCountry[1]=="cr"){country="CR"}}pageData.country=country}else{pageData.country=Common.Utils.Cookie.ReadCookie("s_eVar27")||this.getPaisVisita()}pageData.country=pageData.country.toLowerCase()};this.setGlobalCategory=function(value){Common.Utils.Cookie.CreateCookie("OMNITURE_GLOBAL_CATEGORY",value)};this.getGlobalCategory=function(){return Common.Utils.Cookie.ReadCookie("OMNITURE_GLOBAL_CATEGORY")};this.setGlobalProductId=function(value){Common.Utils.Cookie.CreateCookie("OMNITURE_GLOBAL_PRODUCTID",value)};this.getGlobalProductId=function(){return Common.Utils.Cookie.ReadCookie("OMNITURE_GLOBAL_PRODUCTID")};this.setGlobalPaxCant=function(obj){switch(obj.type){case"inf":this.globalPaxCantInf=obj.value;break;case"cnn":this.globalPaxCantCnn=obj.value;break;case"adt":default:this.globalPaxCantAdt=obj.value;break}var total=this.globalPaxCantInf+this.globalPaxCantCnn+this.globalPaxCantAdt};this.setGlobalTotalAmount=function(value){Common.Utils.Cookie.CreateCookie("OMNITURE_GLOBAL_TOTAL_AMOUNT",value)};this.getGlobalTotalAmount=function(){return Common.Utils.Cookie.ReadCookie("OMNITURE_GLOBAL_TOTAL_AMOUNT")};this.setRankingHotel=function(hotelPosition){if(typeof(hotelPosition)!="object"){var hotelInfo=hotelPosition.split("-");var hotelRanking=parseInt(((hotelInfo[1]-1)*20),10)+parseInt(hotelInfo[0],10);Common.Utils.Cookie.CreateCookie("OMNITURE_RANKING_HOTEL",hotelRanking)}};this.setChannel=function(value){var channel="";if(value){channel+=value}else{channel+=pageData.flow}this.setNamedVar("channel",channel.toLowerCase())};this.setSubsection=function(value){var subsection="";if(value){subsection+=value}else{subsection+=pageData.flow+": "+pageData.section}this.setProp(1,subsection.toLowerCase())};this.setPageName=function(oValues){var pageName="";if(typeof oValues=="object"){for(var e in oValues){pageData[e]=oValues[e]}pageName=pageData.flow+": "+pageData.section+": "+pageData.page}else{if(typeof oValues=="string"){pageData.page=oValues;pageName=pageData.page}else{return false}}this.setNamedVar("pageName",this.quitarAcentos(pageName.toLowerCase()));this.setChannel();this.setSubsection();this.setCodigoPais(pageData.country)};this.setMobilePageName=function(oValues){var pageName="";if(typeof oValues=="object"){for(var e in oValues){pageData[e]=oValues[e]}pageName="mobile: "+pageData.flow+": "+pageData.section+": "+pageData.page;channel="mobile: "+pageData.section;subsection="mobile: "+pageData.flow+": "+pageData.section}else{if(typeof oValues=="string"){pageData.page=oValues;pageName="mobile: "+pageData.page;channel="mobile: ";subsection="mobile: "}else{return false}}this.setNamedVar("pageName",this.quitarAcentos(pageName.toLowerCase()));this.setChannel(channel);this.setSubsection(subsection);this.setCodigoPais(pageData.country)};this.setProducts=function(value){var value=value.replace(/[.]/gi,"");this.setNamedVar("products",value)};this.setCrossSellingFrom=function(value){this.setEVar(65,value)};this.setVariables=function(oValues){if(typeof oValues=="object"){for(var e in oValues){switch(e){case"pageName":this.setPageName(oValues[e]);break;case"mobilePageName":this.setMobilePageName(oValues[e]);break;case"products":this.setProducts(oValues[e]);break;case"subsection":this.setSubsection(oValues[e]);break;case"globalTotalAmount":this.setGlobalTotalAmount(oValues[e]);break;case"globalProductId":this.setGlobalProductId(oValues[e]);break;case"globalCategory":this.setGlobalCategory(oValues[e]);break;case"tipoProducto":this.setTipoProducto(oValues[e]);break;case"type":this.setType(oValues[e]);break;case"tipoDeViaje":this.setTipoDeViaje(oValues[e]);break;case"codigoOrigenBusqueda":this.setCodigoOrigenBusqueda(oValues[e]);break;case"codigoDestinoBusqueda":this.setCodigoDestinoBusqueda(oValues[e]);break;case"codigoCiudadOrigenDestino":this.setCodigoCiudadOrigenDestino(oValues[e]);break;case"globalPaxCant":this.setGlobalPaxCant(oValues[e]);break;case"fechaIda":this.setFechaIda(oValues[e]);break;case"fechavuelta":this.setFechaVuelta(oValues[e]);break;case"fechaVuelta":this.setFechaVuelta(oValues[e]);break;case"cantidadDeAdultos":this.setCantidadDeAdultos(oValues[e]);break;case"cantidadDeNinios":this.setCantidadDeNinios(oValues[e]);break;case"cantidadHabitacionesHotel":this.setCantidadHabitacionesHotel(oValues[e]);break;case"bookingPace":this.setBookingPace(oValues[e]);break;case"compania":this.setCompania(oValues[e]);break;case"horaIda":this.setHoraIda(oValues[e]);break;case"horaVuelta":this.setHoraVuelta(oValues[e]);break;case"codigoDestinoBusquedaPaquetesHotel":this.setCodigoDestinoBusquedaPaquetesHotel(oValues[e]);break;case"fechaIdaPaquetesHotel":this.setFechaIdaPaquetesHotel(oValues[e]);break;case"paisVisita":this.setPaisVisita(oValues[e]);break;case"searchResults":this.setSearchResults(oValues[e]);break;case"searchResultPosition":this.setSearchResultPosition(oValues[e]);break;case"domain":this.setDomain(oValues[e]);break;case"codigoPais":this.setCodigoPais(oValues[e]);break;case"ABtesting":this.setABtesting(oValues[e]);break;case"clase":this.setClase();break;case"tipoClase":this.setTipoClase(oValues[e]);break;case"classRate":this.setClassRate(oValues[e]);break;case"classType":this.setClassType(oValues[e]);break;case"checkoutId":this.setCheckoutId(oValues[e]);break;case"providerAsync":this.setProviderAsync(oValues[e]);break;case"provider":this.setProvider(oValues[e]);break;case"departureMonth":this.setDepartureMonth(oValues[e]);break;case"durationRange":this.setDurationRange(oValues[e]);break;case"codigoOrigenProducto":this.setCodigoOrigenProducto(oValues[e]);break;case"codigoDestinoProducto":this.setCodigoDestinoProducto(oValues[e]);break;case"fromOffers":this.setFromOffers(oValues[e]);break;case"hotelStars":this.setHotelStars(oValues[e]);break;case"codigoPaisDestinoBusqueda":this.setCodigoPaisDestinoBusqueda(oValues[e]);break;case"codigoPaisOrigenBusqueda":this.setCodigoPaisOrigenBusqueda(oValues[e]);break;case"apiMobile":this.setApiMobile(oValues[e]);break;case"intNac":this.setIntNac(oValues[e]);break;case"bookingProvider":this.setBookingProvider(oValues[e]);break;case"crossSellingFrom":this.setCrossSellingFrom(oValues[e]);break;case"ciudadDestinoHotel":this.setCiudadDestinoHotel(oValues[e]);break;case"fechaIdaHotel":this.setFechaIdaHotel(oValues[e]);break;case"fechaVueltaHotel":this.setFechaVueltaHotel(oValues[e]);break;case"rankingHotel":this.setRankingHotel(oValues[e]);break;case"cantidadNinosHotel":this.setCantidadNinosHotel(oValues[e]);break;case"cantidadAdultosHotel":this.setCantidadAdultosHotel(oValues[e]);break;case"events":this.setEvents(oValues[e]);break;default:this.setNamedVar(e,oValues[e])}}}};this.setEvents=function(oValues){if(typeof oValues=="object"){for(var e in oValues){switch(oValues[e]){case"eventPurchase":this.eventPurchase();break;case"eventCheckout":this.eventCheckout();break;case"eventProdView":this.eventProdView();break;case"eventAdd":this.eventAdd();break;case"setSearchResult":this.setSearchResult();break;case"setProductSearches":this.setProductSearches();break;case"setProductDetailView":this.setProductDetailView();break;case"eventTaxesAndFees":this.eventTaxesAndFees();break;case"setSearches":this.setSearches();break;case"setNullSearches":this.setNullSearches();break;case"setCompleteSearch":this.setCompleteSearch();break;case"checkoutIteration":this.checkoutIteration();break;case"setCheckoutPopup":this.setCheckoutPopup();break;case"setLandingResults":this.setLandingResults();break;case"setLandingDetails":this.setLandingDetails();break;case"setDepartureDateChanges":this.setDepartureDateChanges();break;case"setPassangersDistributionChanges":this.setPassangersDistributionChanges();break;case"setNewDistributionSearches":this.setNewDistributionSearches();break;case"setPreBookings":this.setPreBookings();break;case"setProfit":this.setProfit();break;case"setPackageFlights":this.setPackageFlights();break;case"setPackageHotels":this.setPackageHotels();break;case"CrossSellingShow":this.CrossSellingShow();break;case"CrossSellingClick":this.CrossSellingClick();break;case"setLandingHome":this.setLandingHome();break;case"eventFiltroHoteles":this.eventFiltroHoteles();break;default:this.setNamedEvent(oValues[e])}}}};this.eventPurchase=function(){dataEvents.purchase=-1};this.eventCheckout=function(){dataEvents.scCheckout=-1};this.eventProdView=function(){dataEvents.prodView=-1};this.eventAdd=function(){dataEvents.scAdd=-1};this.setSearchResult=function(){this.setEvent(1,-1)};this.setProductSearches=function(value){this.setEvent(1,value)};this.setProductDetailView=function(){dataEvents.event2=-1};this.eventTaxesAndFees=function(){dataEvents.event3=-1};this.setSearches=function(value){this.setEvent(4,value)};this.eventSetNullSearches=function(source_event,value){var eJSON={name:"event5",description:"",source_event:source_event};this.fireEvent(eJSON)};this.setNullSearches=function(value){this.setEvent(5,value)};this.eventOrdenar=function(source_event,value){var value="sort: "+value.toLowerCase();var eJSON={name:"event6",description:"fparadas",source_event:source_event,eVar:"eVar31",value:value};this.fireEvent(eJSON)};this.eventCambioMoneda=function(source_event,value){var value="currency: "+value.toLowerCase();var eJSON={name:"event6",description:"cambiomonedas",source_event:source_event,eVar:"eVar31",value:value};this.fireEvent(eJSON)};this.eventFiltro=function(source_event,value){var value="filter: "+value.toLowerCase();var eJSON={name:"event6",description:"filter",source_event:source_event,eVar:"eVar31",value:value};this.fireEvent(eJSON)};this.eventFiltroHoteles=function(source_event,value){var value="filter: "+value.toLowerCase();var eJSON={name:"event6",description:"filter",source_event:source_event,eVar:"eVar32",value:value};this.fireEvent(eJSON)};this.eventPaginar=function(source_event,value){var value="page: "+value;var eJSON={name:"event6",description:"filter",source_event:source_event,eVar:"eVar31",value:value};this.fireEvent(eJSON)};this.eventGuardarHotel=function(source_event,value){var value=";HTL_"+value.id+"_"+value.destinationCode;var eJSON={name:"event7",description:"addFavorite",source_event:source_event,eVar:"products",value:value};this.fireEvent(eJSON)};this.eventMapaHotel=function(source_event,value){var value=";HTL_"+value.id+"_"+value.destinationCode;var eJSON={name:"event8",description:"hotelMap",source_event:source_event,eVar:"products",value:value};this.fireEvent(eJSON)};this.eventComentariosHotel=function(source_event,value){var value=";HTL_"+value.id+"_"+value.destinationCode;var eJSON={name:"event9",description:"hotelComments",source_event:source_event,eVar:"products",value:value};this.fireEvent(eJSON)};this.eventReviewHotel=function(source_event,value){var value=";HTL_"+value.id+"_"+value.destinationCode;var eJSON={name:"event9",description:"reviewHotel",source_event:source_event,eVar:"products",value:value};this.fireEvent(eJSON)};this.setCompleteSearch=function(){this.setEvent(11,-1)};this.eventCancelAvailableOptions=function(source_event,value){var eJSON={name:"event13",description:"",source_event:source_event};this.fireEvent(eJSON)};this.checkoutIteration=function(){this.setEvent(14,-1)};this.setCheckoutPopup=function(){this.setEvent(15,-1)};this.setLandingResults=function(){this.setEvent(16,-1)};this.setLandingDetails=function(){this.setEvent(17,-1)};this.setDepartureDateChanges=function(){this.setEvent(18,-1)};this.setPassangersDistributionChanges=function(){this.setEvent(19,-1)};this.setNewDistributionSearches=function(){this.setEvent(20,-1)};this.eventButtonClick=function(source_event,value){var eJSON={name:"event21",description:"ButtonClick",source_event:source_event,eVar:"eVar72",value:value};this.fireEvent(eJSON)};this.setPreBookings=function(){this.setEvent(22,-1)};this.setProfit=function(value){this.setEvent(22,value)};this.setPackageFlights=function(){this.setEvent(23,-1)};this.setPackageHotels=function(){this.setEvent(24,-1)};this.CrossSellingShow=function(){this.setEvent(37,-1)};this.CrossSellingClick=function(source_event){var eJSON={name:"event38",description:"ButtonClick",source_event:source_event};this.fireEvent(eJSON)};this.setBestPriceShow=function(source_event){var eJSON={name:"event40",description:"BestPriceShow",source_event:source_event};this.fireEvent(eJSON)};this.setBestPriceClick=function(source_event){var eJSON={name:"event41",description:"BestPriceClick",source_event:source_event};this.fireEvent(eJSON)};this.setLandingHome=function(){this.setEvent(42,-1)};this.setAdicionales=function(value){this.setList(1,value.toUpperCase())};this.setTipoProducto=function(value){this.setEVar(1,value.toLowerCase());this.setGlobalCategory(value)};this.getTipoProducto=function(value){return this.getEVar(1)};this.setType=function(value){this.setProp(2,value)};this.setTipoDeViaje=function(value){var value=value.toLowerCase();this.setEVar(2,value)};this.setCodigoOrigenBusqueda=function(value){var value_array=value.split(",");if(value_array.length>1){this.setEVar(3,value_array[0].toUpperCase())}else{this.setEVar(3,value.toUpperCase())}};this.setCodigoDestinoBusqueda=function(value){var value_array=value.split(",");var value_count=value_array.length-1;if(value_array.length>1){this.setEVar(4,value_array[value_count].toUpperCase())}else{this.setEVar(4,value.toUpperCase())}};this.setCodigoCiudadOrigenDestino=function(){var value=this.getEVar(3).toUpperCase()+"_"+this.getEVar(4).toUpperCase();this.setEVar(5,value)};this.setItinerario=function(value){this.setEVar(5,value.toUpperCase())};this.setFechaIda=function(value){var value_array=value.split(",");if(value_array.length>1){value=value_array[0].replace(/[-]/gi,"");this.setEVar(6,value)}else{value=value.replace(/[-]/gi,"");this.setEVar(6,value)}};this.setFechaVuelta=function(value){var value=value.replace(/[-]/gi,"");this.setEVar(7,value)};this.setCantidadDeAdultos=function(value){this.setEVar(8,value);var obj={value:value,type:"adt"};this.setGlobalPaxCant(obj)};this.setCantidadDeNinios=function(value){var obj={value:value,type:"cnn"};this.setGlobalPaxCant(obj);this.setEVar(9,value)};this.setCiudadDestinoHotel=function(value){this.setEVar(11,value)};this.setFechaIdaHotel=function(value){var value=value.replace(/[-]/gi,"");this.setEVar(12,value)};this.setFechaVueltaHotel=function(value){var value=value.replace(/[-]/gi,"");this.setEVar(13,value)};this.setCantidadHabitacionesHotel=function(value){this.setEVar(14,value)};this.setCantidadAdultosHotel=function(value){this.setGlobalPaxCant(value,"adt");this.setEVar(15,value)};this.setCantidadNinosHotel=function(value){this.setGlobalPaxCant(value,"cnn");this.setEVar(16,value)};this.setBookingPace=function(value){var d=new Date();var t1=d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();var value_array=value.split(",");if(value_array.length>1){var t2=value_array[0]}else{var t2=value}var one_day=1000*60*60*24;var x=t1.split("-");var y=t2.split("-");var date1=new Date(x[0],(x[1]-1),x[2]);var date2=new Date(y[0],(y[1]-1),y[2]);var month1=x[1]-1;var month2=y[1]-1;if(date2<date1){date2=new Date()}var _Diff=Math.ceil((date2.getTime()-date1.getTime())/(one_day));this.setEVar(25,_Diff);this.setProp(3,_Diff)};this.setCompania=function(value){this.setEVar(18,value)};this.setHoraIda=function(value){this.setEVar(19,value)};this.setHoraVuelta=function(value){this.setEVar(20,value)};this.setCodigoDestinoBusquedaPaquetesHotel=function(value){var value_array=value.split(",");var value_count=value_array.length-1;if(value_array.length>1){this.setEVar(22,value_array[value_count].toUpperCase())}else{this.setEVar(22,value.toUpperCase())}};this.setFechaIdaPaquetesHotel=function(value){var value_array=value.split(",");if(value_array.length>1){value=value_array[0].replace(/[-]/gi,"");this.setEVar(23,value)}else{value=value.replace(/[-]/gi,"");this.setEVar(23,value)}};this.setFechaVueltaPaquetesHotel=function(value){var value=value.replace(/[-]/gi,"");this.setEVar(24,value)};this.setPaisVisita=function(value){this.setEVar(27,value)};this.getPaisVisita=function(){return this.getEVar(27)};this.setSearchResults=function(value){if(value==1){var rankingHotel=Common.Utils.Cookie.ReadCookie("OMNITURE_RANKING_HOTEL");if(rankingHotel){this.setEVar(30,rankingHotel)}}else{if(value==2){var rankingVuelo=Common.Utils.Cookie.ReadCookie("OMNITURE_RANKING_VUELO");if(rankingVuelo){this.setEVar(30,rankingVuelo)}}else{if(value==3){var rankingPaquete=Common.Utils.Cookie.ReadCookie("OMNITURE_RANKING_PAQUETE");if(rankingPaquete){this.setEVar(30,rankingPaquete)}}else{if(value==4){var rankingCruise=Common.Utils.Cookie.ReadCookie("OMNITURE_RANKING_CRUISE");if(rankingCruise){this.setEVar(30,rankingCruise)}}else{this.setEVar(30,0)}}}}};this.setSearchResultPosition=function(value){this.setEVar(30,value)};this.setDomain=function(value){this.setProp(15,value);this.setEVar(35,value)};this.setCodigoPais=function(value){this.setEVar(36,value.toLowerCase());this.setProp(16,value.toLowerCase())};this.setABtesting=function(obj){var pageName=obj.pageName;var pageName_array=pageName.split(":");if(pageName_array.length<obj.position){var versionFinal=": "+obj.identificador+": v"+obj.version}else{var versionFinal=" "+obj.identificador+": v"+obj.version}pageName_array.splice(obj.position,0,versionFinal);var value=pageName_array.join(":");if(obj.version==1){this.setEVar(37,value);this.setProp(17,value);this.setEvent(26,-1)}else{if(obj.version==2){this.setEVar(38,value);this.setProp(18,value);this.setEvent(27,-1)}else{if(obj.version==3){this.setEVar(39,value);this.setProp(19,value);this.setEvent(28,-1)}else{if(obj.version==4){this.setEVar(42,value);this.setProp(20,value);this.setEvent(29,-1)}else{if(obj.version==5){this.setEVar(43,value);this.setProp(21,value);this.setEvent(30,-1)}else{if(obj.version==6){this.setEVar(44,value);this.setProp(22,value);this.setEvent(31,-1)}else{if(obj.version==7){this.setEVar(45,value);this.setProp(23,value);this.setEvent(32,-1)}else{if(obj.version==8){this.setEVar(46,value);this.setProp(24,value);this.setEvent(33,-1)}else{if(obj.version==9){this.setEVar(47,value);this.setProp(25,value);this.setEvent(34,-1)}else{if(obj.version==10){this.setEVar(48,value);this.setProp(26,value);this.setEvent(35,-1)}}}}}}}}}}};this.setClase=function(){var clase=Common.Utils.Cookie.ReadCookie("OMNITURE_SEARCH_FLIGHTS_CLASS");if(clase=="C"){this.setEVar(40,"EJEC")}else{this.setEVar(40,"No Business")}};this.setTipoClase=function(value){var clase=value;if(clase=="C"){this.setEVar(41,"EJEC")}else{if(clase=="YC"){this.setEVar(41,"ECON")}else{if(clase=="YS"){this.setEVar(41,"ECON")}else{if(clase=="Y"){this.setEVar(41,"ECON")}else{if(clase=="F"){}}}}}};this.setClassRate=function(value){this.setEVar(40,value)};this.setClassType=function(value){this.setEVar(41,value)};this.setCheckoutId=function(value){this.setEVar(49,value)};this.setProviderAsync=function(value){var omnitureDataCollectorAjax=new Common.OmnitureDataCollector();omnitureDataCollectorAjax.setNamedVar("eVar51",value);omnitureDataCollectorAjax.beforeApply(s);s=omnitureDataCollectorAjax.applyData(s);omnitureDataCollectorAjax.afterApply(s);omnitureDataCollectorAjax.sendData(s)};this.setProvider=function(value){this.setEVar(51,value)};this.setDepartureMonth=function(value){var month=value.split("-")[0];var year=value.split("-")[1];var departureMonth=year.toString()+month.toString();if(month>0&&month<10){departureMonth=year.toString()+"0"+month.toString()}this.setEVar(53,departureMonth)};this.setDurationRange=function(value){this.setEVar(54,value)};this.setCodigoOrigenProducto=function(value){this.setEVar(59,value)};this.setCodigoDestinoProducto=function(value){this.setEVar(60,value)};this.setFromOffers=function(value){this.setEVar(66,value)};this.getFromOffers=function(){return this.getEVar(66)};this.setHotelStars=function(value){this.setEVar(67,value)};this.setCodigoPaisDestinoBusqueda=function(value){this.setEVar(70,value.toUpperCase())};this.setCodigoPaisOrigenBusqueda=function(value){this.setEVar(71,value.toUpperCase())};this.getTipoDeViaje=function(value){if(value==1){return"OW"}else{if(value==2){return"RT"}else{if(value==3){return"MC"}else{return"NULL"}}}};this.setApiMobile=function(value){this.setEVar(73,value)};this.setIntNac=function(value){this.setEVar(74,value.toUpperCase())};this.setBookingProvider=function(value){this.setEVar(75,value.toUpperCase())};this.setCustomLink=function(linkName){this.setLink(true,"o",linkName)};this.setExitLink=function(linkName){this.setLink(true,"e",linkName)};this.setDownloadLink=function(linkName){this.setLink(true,"d",linkName)};this.setLink=function(delay,linkType,linkName){s.tl(delay,linkType,linkName)};this.quitarAcentos=function(value){var __r={"À":"A","Á":"A","Â":"A","Ã":"A","Ä":"A","Å":"A","Æ":"E","È":"E","É":"E","Ê":"E","Ë":"E","Ì":"I","Í":"I","Î":"I","Ò":"O","Ó":"O","Ô":"O","Ö":"O","Ù":"U","Ú":"U","Û":"U","Ü":"U","Ñ":"N"};return value.replace(/[ÀÁÂÃÄÅÆÈÉÊËÌÍÎÒÓÔÖÙÚÛÜÑ]/gi,function(m){var ret=__r[m.toUpperCase()];if(m===m.toLowerCase()){ret=ret.toLowerCase()}return ret})};this.omnitureDataFromHashes=function(){var omnitureDataCollector=this;var hashData=window.location.hash;if(hashData){var additionalData=hashData.split("&&");$.each(additionalData,function(index,value){var data=value.split("=");if(data.length==2){var hashKey=data[0].replace("#","");var hashValue=data[1];switch(hashKey){case"ov":var varData=hashValue.split("||");omnitureData[varData[0]]=varData[1];omnitureDataCollector.removeOmnitureHash(additionalData,index);break;case"oe":var eventName=hashValue;omnitureData.events.push(eventName);omnitureDataCollector.removeOmnitureHash(additionalData,index);break}}})}};this.removeOmnitureHash=function(additionalData,index){var hash=additionalData[index];if(index!=(additionalData.length-1)){hash=hash+"&&"}window.location.hash=window.location.hash.replace(hash,"")};var COUNTRY_LIST="AR|BO|BR|CL|CO|CR|EC|SV|ES|GT|HN|MX|NI|PA|PY|PE|PR|DO|UY|US|VE|INC";this.errMessages="";var data=new Array();var dataEvents=new Array();var DEFAULT_REPORT_SUITE="despegardev";var pageData={country:"unmarked-country",flow:"unmarked-flow",section:"unmarked-section",page:"unmarked-page"};this.data=data;this.dataEvents=dataEvents;this.setAutomaticCountry()};
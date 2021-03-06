/*****************************************************************************
 *         In the name of God the Most Beneficent the Most Merciful          *
 *___________________________________________________________________________*
 *   This program is free software: you can redistribute it and/or modify    *
 *   it under the terms of the GNU General Public License as published by    *
 *   the Free Software Foundation, either version 3 of the License, or       *
 *   (at your option) any later version.                                     *
 *___________________________________________________________________________*
 *   This program is distributed in the hope that it will be useful,         *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *   GNU General Public License for more details.                            *
 *___________________________________________________________________________*
 *   You should have received a copy of the GNU General Public License       *
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *___________________________________________________________________________*
 *                       Created by AliReza Ghadimi                          *
 *     <http://AliRezaGhadimi.ir>    LO-VE    <AliRezaGhadimy@Gmail.com>     *
 *****************************************************************************/
/**
 * iDb.js
 *  Very simple javascript library to work with localStorage as an indexedDB (key-value store)
 */
var iDb = Object();
/**
 *
 * @param filter
 * @param n
 * @returns {Array}
 */
iDb.keys = function (filter,n){
    if(n === undefined){
        n = 0;
    }
    var len     = localStorage.length;
    var regex   = new RegExp('^'+filter.replace('\\','\\\\')+'$');
    var re      = [];
    var k       = 0;
    var tmp     = '';
    for(var i = 0;i < len;i++){
        if(regex.test(localStorage.key(i))){
            tmp     = regex.exec(localStorage.key(i));
            re[k++] = tmp[n];
        }
    }
    return re;
};
/**
 *
 * @param name
 */
iDb.get = function (name){
    return localStorage.getItem(name);
};
/**
 *
 * @param name
 * @param value
 */
iDb.set = function (name,value){
    if(iDb.numberRegex.test(value)){
        value = parseInt(value);
    }
    template.set(name,value);
    return localStorage.setItem(name,value);
};
/**
 *
 * @returns {number}
 */
iDb.length = function(){
    return localStorage.length;
};
iDb.isset   = function(name){
    return iDb.keys(name).length !== 0;
};
/**
 *
 * @param name
 */
iDb.incr = function(name){
    if(!iDb.isset(name)){
        iDb.set(name,0);
    }
    return iDb.set(name,parseInt(iDb.get(name))+1);
};
/**
 *
 * @param name
 * @param value
 */
iDb.incrby = function(name,value){
    if(!iDb.isset(name)){
        iDb.set(name,0);
    }
    return iDb.set(name,parseInt(iDb.get(name))+value);
};
/**
 *
 * @param json
 * @constructor
 */
iDb.SET_JSON = function(json){
    json = JSON.parse(json);
    for(var key in json){
        iDb.set(key,json[key]);
    }
};
/**
 *
 * @param number
 * @returns {string}
 */
iDb.key     = function(number){
    return localStorage.key(number);
};
/**
 *
 * @returns {Storage}
 */
iDb.array   = function(){
    return localStorage;
};
iDb.numberRegex = new RegExp('^[0-9]+$');
iDb.vue     = function(){
    var keys = iDb.keys('.+');
    var val;
    for(var key in keys){
        key = iDb.key(key);
        val = iDb.get(key);
        if(iDb.numberRegex.test(val)){
            val = parseInt(val);
        }
        template.set(key,val);
    }
};
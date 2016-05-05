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
 *  Very simple javascript library to work with sessionStorage as an indexedDB (key-value store)
 */
var iDb = Object();
/**
 *
 * @param filter
 * @returns {Array}
 */
iDb.keys = function (filter){
    var len = sessionStorage.length;
    var regex = new RegExp('^'+filter+'$');
    var re= [];
    var k = 0;
    for(i = 0;i < len;i++){
        if(regex.test(sessionStorage.key(i))){
            re[k++] = sessionStorage.key(i);
        }
    }
    re.length = k-1;
    return re;
};
/**
 *
 * @param name
 */
iDb.get = function (name){
    return sessionStorage.getItem(name);
};
/**
 *
 * @param name
 * @param value
 */
iDb.set = function (name,value){
    return sessionStorage.setItem(name,value);
};
/**
 *
 * @returns {number}
 */
iDb.length = function(){
    return sessionStorage.length;
};
/**
 *
 * @param name
 */
iDb.incr = function(name){
    return sessionStorage.setItem(name,parseInt(sessionStorage.getItem(name))+1);
};
/**
 *
 * @param name
 * @param value
 */
iDb.incrby = function(name,value){
    return sessionStorage.setItem(name,parseInt(sessionStorage.getItem(name))+value);
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
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
var forms       = Object();
/**
 * un success :(
 * But I'll try again and again
 * @param el
 * @returns {Object}
 */
forms.readFile  = function(el){
    var re,reader = new FileReader();
    if(el){
        reader.readAsBinaryString(el);
    }
    console.log(reader.result == '');
    while(true) {
        console.log(reader.result);
        if (reader.result != '') {
            return reader.result;
        }
    }
};
forms.onSubmit  = function(form){

};
forms.load      = function(){
    $('form').each(function(form){
        form = $(form);
        if(form.data('name') !== undefined){
            form.submit(onSubmit);
        }
    });
};
var template    = Object();
template.load   = function(tem){
    template.vue= new Vue({
        el: 'body',
        data: iDb.array(),
        template: tem,
        replace: false
    });
};
template.set    = function(name,value){
    template.vue.$set(name,value);
};
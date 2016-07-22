
$('#search-c').keypress(function(e) {if (e.which == 13) $('#btn-search-c').click();});
$('#search-p').keypress(function(e) {if (e.which == 13) $('#btn-search-p').click();});


var request = function(name, params, cb, err) {
    if (params == undefined)
        params = {};

    params['cmd'] = name;
    $.post('/php/get/__admin_get.php', params, function (data) {
        var res = {};
        try {
            res = JSON.parse(data);
        } catch (ex) {
            //alert('Exception parsing data!');
            if (err != undefined) err('Exception parsing data!', ex);
            return;
        }
        if (res.success != undefined && res.success == true)
            cb(res.data);
        else {
            if (err != undefined) err(res.message);
            /*else*/ alert(res.message);
        }
    });
};

request('get_min_val_atacado', {}, function (data) {
    if (data.error == undefined) {
        sessionStorage.setItem('min_valor_atacado', data.valor);
    } else {
        alert(data.error);
    }
});

var display = function (el, status) {
    if (status === undefined) status = true;
    el.css('display', status ? 'block' : 'none');
}

var disable = function (el, status) {
    if (status === undefined) status = true;
    el.prop('disabled', status).css('pointerEvents', !status ? 'auto' : 'none');
}

var loading = function (status, a, b) {
    disable(a, status);
    b.css('display', status ? 'inline-block' : 'none');
}


var order = {
    client: {
        get: function () {
            return $('#list-c').val();
        },
        displaySearchBox: function () { display($('#div-search-c')); display($('#div-list-c'), false); },
        displayListBox: function () { display($('#div-list-c')); display($('#div-search-c'), false); },
        displayInfo: function (c, n) {
            if (c != null) {
                $('#cli-nome').text(c.nome);
                $('#cli-email').text(c.email);
                $('#cli-creditos').text(c.creditos);
                this.phone.list(c.telefones, n);
            }
            display($('#tbl-c'), c != null);
        },
        getSearchText: function () { return $('#search-c').val(); },
        clearSearchText: function () { $('#search-c').val(''); },
        fillList: function (res) {
            for (var i = 0; i < res.length; ++i) {
                $('#list-c').append('<option value="' + res[i].id + '">' + res[i].nome + '(' + res[i].email + ')</option>');
            }
            $('#list-c').prop('selectedIndex', -1);
        },
        clearList: function () {
            $('#list-c').empty().prop('disabled', false);
        },
        clear: function () {
            this.clearList();
            this.clearSearchText();
            this.displayInfo(null);
            this.displaySearchBox();
            this.address.clear();
        },
        lockSearch: function () {
            loading(true, $('#search-c, #btn-search-c'), $('#loading-c'));
        },
        unlockSearch: function () {
            loading(false, $('#search-c, #btn-search-c'), $('#loading-c'));
        },
        doSearch: function () {
            var str = this.getSearchText();

            if (str == null || str == '') {
                alert('Preencha o campo de busca!');
                return false;
            }
            this.lockSearch();

            var cb = function (res) {
                this.unlockSearch();
                this.displayListBox();
                this.fillList(res);
            };
            request('find_client', { 'name': str }, cb.bind(this), this.unlockSearch.bind(this));
        },
        lockSelect: function () {
            loading(true, $('#list-c, #btn-new-search-c'), $('#loading-c2'));
        },
        unlockSelect: function(){
            loading(false, $('#list-c, #btn-new-search-c'), $('#loading-c2'));
        },
        selectClient: function (cid, eid, n) {
            this.lockSelect();
            var lc = $('#list-c');
            var cb = function (c) {
                this.unlockSelect();
                this.displayInfo(c, n);
                lc.prop('disabled', true);
                this.address.list(c.enderecos, eid);
            };
            cid = cid == undefined ? lc.val() : cid;
            request('get_client', { 'id': cid }, cb.bind(this), this.unlockSelect.bind(this));
        },
        load: function (cid, name, eid, tel) {
            $('#list-c').append('<option value="' + cid + '">' + name + '</option>');
            this.displayListBox();
            this.selectClient(cid, eid, tel);
        },
        register: function () {
            $('#btn-search-c').unbind().click(this.doSearch.bind(this));
            $('#list-c').unbind().change(this.selectClient.bind(this, undefined, undefined));
            $('#btn-new-search-c').unbind().click(this.clear.bind(this));

            this.address.register();
            this.phone.register();
        },
        address: {
            get: function () {
                return $('#list-e').val();
            },
            list: function (e, id) {
                if (e != undefined) {
                    var el = $('#list-e');
                    el.empty();
                    for (var i = 0; i < e.length; ++i) {
                        var ee = e[i];
                        var str = ee.endereco + ", n° " + ee.numero + " - " + ee.bairro.bairro + ", " + ee.bairro.cidade.cidade + ", " + ee.bairro.cidade.estado.estado + " - " + ee.cep;
                        el.append('<option ' + (ee.id == id ? 'selected="selected" ' : '') + 'value="' + ee.id + '">' + str + '</option>');
                    }
                    if (id <= 0) el.prop('selectedIndex', -1);
                    $('#list-e').prop('disabled', false).change();
                    $('#add-endereco').prop('disabled', false);
                }
            },
            clear: function () {
                $('#list-e').empty().prop('disabled', true);
                $('#add-endereco').prop('disabled', true);
                display($('#display-frete'), false);
                this.clearNewAddress();
            },
            clearNewAddress: function () {
                display($('#new-endereco'),false);
                $('#cep').val('');
                $('#estado').prop('selectedIndex', -1);
                $('#cidade').empty();
                $('#bairro').empty();
                $('#endereco').val('');
                $('#numero').val('');
                $('#complemento').val('');
            },
            loadLocal: function (n, a, b, id, cb_) {
                if (id === undefined) id = -1;
                var s = $(b);
                s.empty();
                var cb = function (data) {
                    for (var i = 0; i < data.length; ++i) {
                        s.append('<option ' + (id == data[i].id ? 'selected="selected"' : '') + ' value="' + data[i].id + '">' + data[i].nome + '</option>')
                    }
                    if (id <= 0)
                        s.prop('selectedIndex', -1);
                    if (cb_ != undefined) cb_();
                };
                request(n, { 'id': $(a).val() }, cb);
            },
            displayDistrictList: function (status) {
                if (status === undefined) status = true;
                if (status) {
                    $('#nome-bairro').val('');
                } else {
                    if ($('#cidade').val() <= 0) { alert('Selecione uma cidade!'); return; }
                    this.unlockAdd();
                }
                display($('#select-bairro'), status);
                display($('#new-bairro'), !status);
                disable($('#save-endereco'), !status);
            },
            lockAdd: function () {
                loading(true, $('#save-bairro, #nome-bairro'), $('#loading-sb'));
            },
            unlockAdd: function () {
                loading(false, $('#save-bairro, #nome-bairro'), $('#loading-sb'));
            },
            saveDistrict: function () {
                var cid = $('#cidade').val();
                if (cid > 0) {
                    var name = $('#nome-bairro').val();
                    if (name == '') {
                        alert('Digite o nome do bairro!');
                        this.unlockAdd();
                        return;
                    }
                    this.lockAdd();

                    var cb = function (data) {
                        var cb2 = (function () {
                            this.unlockAdd();
                            this.displayDistrictList();
                        }).bind(this);
                        
                        if (data.error != undefined) {
                            alert(data.error);
                            cb2();
                        } else {
                            this.loadLocal('get_bairros', '#cidade', '#bairro', data.id, cb2, this.unlockAdd.bind(this));
                        }
                    };

                    request('save_bairro', { 'id': cid, 'nome': name }, cb.bind(this), this.unlockAdd.bind(this));
                } else {
                    alert('Selecione uma cidade!');
                }
            },
            loading: function (a, b) {
                var s = b ? $('#loading-se') : $('#loading-cep');
                loading(a, $('#complemento, #numero, #endereco, #bairro, #cidade, #estado, #cep, #search-cep, #add-bairro, #save-endereco'), s);
            },
            lock: function (ls) {
                this.loading(true, ls);
            },
            unlock: function (ls) {
                this.loading(false, ls);
            },
            loadByCep: function () {
                var cep = $('#cep').val();
                if (cep == '') return;
                this.lock(false);

                var cb = function (data) {
                    var unlock = this.unlock.bind(this);
                    if (data.eid != undefined) {
                        $('#estado').find('option[value="'+data.eid+'"]').prop('selected', true);
                        this.loadCities(data.cid, (function(){
                            this.loadDistrict(data.bid, (function(){
                                $('#endereco').val(data.endereco);
                                $('#search-cep').css('pointerEvents', 'auto');
                                $('#cep').prop('disabled', false);
                                unlock();
                            }).bind(this), unlock);
                        }).bind(this), unlock);
                    }
                };
                request('get_by_cep', {'cep': cep}, cb.bind(this), this.unlock.bind(this, false));
            },
            addNew: function () {
                $('#new-endereco').css('display', 'inline-block');
                this.displayDistrictList();
            },
            save: function () {
                var cep = $('#cep').val();
                var bid = $('#bairro').val();
                var end = $('#endereco').val();
                var num = $('#numero').val();
                var comp = $('#complemento').val();
                var cid = $('#list-c').val();

                if (cep == '') { alert('Preencha o CEP!'); return; }
                if (bid <= 0) { alert('Selecione o bairro!'); return; }
                if (end == '') { alert('Digite o endereço!'); return; }
                if (num == '') { alert('Digite o número!'); return; }
                if (cid <= 0) { alert('Selecione um cliente!'); return; }

                this.lock(true);

                var cb = function (data) {
                    var unlock = this.unlock.bind(this, true);
                    if (data.result != undefined) {
                        if (data.result > 0) {
                            request('get_client', { 'id': cid }, (function (c) {
                                this.list(c.enderecos, data.result);
                                this.clearNewAddress();
                                $('#list-e').change();
                                unlock();
                            }).bind(this), unlock);
                        } else {
                            alert('Não foi possivel cadastrar o endereço!');
                            unlock();
                        }
                    } else {
                        alert('Não foi possivel cadastrar o endereço: "' + data.error + '"!');
                        unlock();
                    }
                };

                request('save_endereco', { 'cid': cid, 'bid': bid, 'endereco': end, 'cep': cep, 'numero': num, 'complemento': comp },
                    cb.bind(this), this.unlock.bind(this, true));
            },
            loadStates: function (id) {
                $('#cidade, #bairro').empty();
                this.loadLocal('get_estados', '', '#estado', id);
            },
            loadCities: function (id, cb) {
                $('#bairro').empty();
                this.loadLocal('get_cidades', '#estado', '#cidade', id, cb);
            },
            loadDistrict: function (id, cb) {
                this.loadLocal('get_bairros', '#cidade', '#bairro', id, cb);
            },
            register: function () {
                $('#add-bairro').unbind().click(this.displayDistrictList.bind(this, false));
                $('#cancel-bairro').unbind().click(this.displayDistrictList.bind(this));
                $('#save-bairro').unbind().click(this.saveDistrict.bind(this));
                $('#search-cep').unbind().click(this.loadByCep.bind(this));

                $('#add-endereco').unbind().click(this.addNew.bind(this));
                $('#save-endereco').unbind().click(this.save.bind(this));
                $('#cancel-endereco').unbind().click(this.clearNewAddress.bind(this));

                $('#estado').unbind().change(this.loadCities.bind(this, -1));
                $('#cidade').unbind().change(this.loadDistrict.bind(this));
                $('#cep').keyup(function cep() {
                    var v = this.value;
                    v = v.replace(/\D/g, "");
                    v = v.replace(/^(\d{5})(\d)/, "$1-$2");
                    this.value = v;
                });
                this.loadStates();
            }
        },
        phone: {
            get: function () {
                return $('#cli-tels').val();
            },
            displayList: function (status) {
                if (status === undefined) status = true;
                display($('#new-tel'), !status);
                display($('#select-tels'), status);
                if (status) $('#num-tel').val('');
            },
            get: function () {
                return $('#cli-tels').val();
            },
            getText: function () { return $('#num-tel').val(); },
            list: function (numbers, n) {
                this.displayList(true);
                var tels = $('#cli-tels').empty();
                for (var i = 0; i < numbers.length; ++i) {
                    tels.append('<option '+ (n == numbers[i] ? 'selected' : '' )+' >' + numbers[i] + '</option>');
                }
            },
            lock: function () {
                loading(true, $('#save-tel, #cancel-tel, #num-tel'), $('#loading-t'));
            },
            unlock: function () {
                loading(false, $('#save-tel, #cancel-tel, #num-tel'), $('#loading-t'));
            },
            addPhone: function () {
                this.displayList(false);
                this.unlock();
            },
            saveNumber: function () {
                var cid = $('#list-c').val();
                if (cid <= 0) { alert('Selecione um cliente!'); return false; }
                var tel = this.getText();
                if (tel == '') {
                    alert('Digite o telefone!');
                    return false;
                }
                this.lock();

                var cb = function (data) {
                    this.unlock();
                    if (data.telefones != undefined) this.list(data.telefones);
                    else alert(data.error);
                };
                request('add_client_tel', { 'id': cid, 'tel': tel }, cb.bind(this), this.unlock.bind(this));
            },
            register: function () {
                $('#add-tel').unbind().click(this.addPhone.bind(this));
                $('#save-tel').unbind().click(this.saveNumber.bind(this));
                $('#cancel-tel').unbind().click(this.displayList.bind(this));
                $('#num-tel').keyup(function () {
                    var v = this.value;
                    v = v.replace(/\D/g, "");
                    if (v.length <= 10)
                        v = v.replace(/^(\d{2})(\d{0,4})(\d{0,4})/, "($1) $2-$3");
                    else
                        v = v.replace(/^(\d{2})(\d{0,5})(\d{0,4})/, "($1) $2-$3");
                    this.value = v;
                });
            }
        }
    },
    shipping: {
        get: function () {
            return $('#tipo-frete').val();
        },
        list: function (data) {
            var tp = $('#tipo-frete').empty();
            for (var i = 0; i < data.length; ++i) {
                tp.append('<option value="' + data[i].id + '">' + data[i].nome + '</option>');
            }
            tp.prop('selectedIndex', -1);
        },
        clear: function () {
            display($('#display-frete'), false);
            $('#tipo-frete').prop('selectedIndex', -1);
        },
        loaded: false,
        load_cb: undefined,
        loadTypes: function () {
            request('get_tipo_frete', {}, (function (data) {
                this.list(data);
                this.loaded = true;
                if (this.load_cb != undefined)
                    this.load_cb();
                this.load_cb = undefined;
            }).bind(this));
        },
        load: function (id) {
            this.load_cb = function () { $('#tipo-frete').val(id); };
            if (this.loaded)
                this.load_cb();
        },
        onTypeChange: function () {
            var fn = function () { };
            /*
            if ($(this).val() == <?php echo TipoFrete::MOTOBOY;?>) {
            */
            if ($(this).val() == 3) {
                fn = function () {
                    var eid = $('#list-e').val();
                    if (eid == null || eid == '') return;
                    request('get_valor_frete', { id: eid }, function (data) {
                        if (data.valor != undefined) {
                            var disp = true;
                            if (data.valor == -1) {
                                alert('Frete indisponivel para este endereço!');
                                $('#list-e').prop('selectedIndex', -1);
                                disp = false;
                            } else {
                                $('#valor-frete').text(data.valor);
                            }
                            display($('#display-frete'), disp);
                        } else {
                            alert(data.error);
                        }
                    });
                };
            } else {
                $('#display-frete').css('display', 'none');
            }

            fn();

            $('#list-e').unbind('change').change(fn);
        },
        register: function () {
            $('#tipo-frete').change(this.onTypeChange);
            this.loadTypes();
        }
    },
    product: {
        displaySearchBox: function (status) {
            if (status == undefined) status = true;
            display($('#div-search-p'), status);
            display($('#div-list-p'), !status);
        },
        lock: function () {
            loading(true, $('#search-p, #filter-by-c, #filter-by-p, #btn-search-p'), $('#loading-p'));
        },
        unlock: function () {
            loading(false, $('#search-p, #filter-by-c, #filter-by-p, #btn-search-p'), $('#loading-p'));
        },
        list: function (produtos) {
            var pl = $('#list-p').empty();
            for (var i = 0; i < produtos.length; ++i) {
                pl.append('<option value="' + produtos[i].id + '">' + produtos[i].nome + '  [' + produtos[i].valor + '/' + produtos[i].valorAtacado + '  (' + produtos[i].qtdAtacado + ')]</option>');
            }
            pl.prop('selectedIndex', -1);
            this.displaySearchBox(false);
        },
        find: function () {
            var cat = $('#filter-by-c').hasClass('active') ? 1 : 0;
            this.lock();
            var cb = function (data) {
                this.list(data);
                this.unlock();
            };
            request('product_list', { 'busca': $('#search-p').val(), 'categoria': cat }, cb.bind(this), this.unlock.bind(this));
        },
        clear: function () {
            $('#list-p').empty();
            $('#search-p').val('');
            display($('#tbl-p').empty(), false);
            this.displaySearchBox();
        },
        listItems: function (produto) {
            var pt = $('#tbl-p').empty();
            pt.css('display', 'table');
            var use_cor = false;
            var use_tam = false;
            if (produto.itens.length > 0) {
                use_tam = produto.itens[0].tamanho != undefined;
                use_cor = produto.itens[0].cor != undefined;
            }
            var str = '<tr>' + (use_cor ? '<th style="width:25%;" >Cor</th>' : '') +
                (use_tam ? '<th style="width:30%;" >Tamanho</th>' : '') +
                '<th >Estoque</th><th></th style="width:10%;"></tr>';
		    pt.append(str);
            for (var i = 0; i < produto.itens.length; ++i) {
                var ii = produto.itens[i];

                if (ii.estoque > 0) {
                    var cor = '';
                    if (ii.cor != undefined) {
                       if (ii.cor.foto != undefined) {
                           cor = '<span class="color-box" style="background-image:url(' + ii.cor.foto.pasta + ii.cor.foto.nome + ')"></span>'
                       } else {
                           for (var j = 0; j < ii.cor.hexadecimais.length; ++j) {
                               cor += '<span class="color-box" style="background-color:' + ii.cor.hexadecimais[j] + '"></span>'
                           }
                       }
                    } else {
                        cor = '';
                    }

                    var tamanho = '';
                    if (ii.tamanho != undefined) {
                        tamanho = ii.tamanho.tamanho;
                    }

                    pt.append('<tr>' + (use_cor ? '<td>' + cor + ' (' + ii.cor.cor + ')</td>' : '') + (use_tam ? '<td>' + tamanho + '</td>' : '') +'<td>' + ii.estoque +
                        '</td><td><input type="text" class="qtd-box" name="' + ii.id + '"value="1">' +
                        '<span class="btn btn-p btn-add-p" data-id="' + ii.id + '"><i class="icon-plus" ></i></span>' +
                        //'<span class="btn btn-p btn-rem-p"><i class="icon-minus" data-id="'+ii.id+'"></i></span>' +
                        '</td></tr>');

                    
                    pt.find('.btn-add-p[data-id=' + ii.id + ']').click(this.cart.add_fn(ii.id, cor, tamanho, ii.estoque, produto));
                }
            }
        },
        lockSelect: function () {
            loading(true, $('#list-p, #btn-new-search-p'), $('#loading-i'));
        },
        unlockSelect: function () {
            loading(false, $('#list-p, #btn-new-search-p'), $('#loading-i'));
        },
        loadProductItems: function () {
            this.lockSelect();
            $('#tbl-p').empty();
            var cb = function (data) {
                this.listItems(data);
                this.unlockSelect();
            };
            request('product_items', { 'id': $('#list-p').val() }, cb.bind(this), this.unlockSelect.bind(this));
        },
        filterByCategory: function (status) {
            var a = $('#filter-by-p');
            var b = $('#filter-by-c');
            if (status) {
                var tmp = a;
                a = b;
                b = tmp;
            }
            a.addClass('active');
            b.removeClass('active');
        },
        register: function (parent) {
            this.cart = parent.cart;
            $('#btn-search-p').unbind().click(this.find.bind(this));
            $('#btn-new-search-p').unbind().click(this.clear.bind(this));
            $('#list-p').unbind().change(this.loadProductItems.bind(this));
            $('#filter-by-p').unbind().click(this.filterByCategory.bind(this, false));
            $('#filter-by-c').unbind().click(this.filterByCategory.bind(this, true));
            this.filterByCategory(false);
        }
    },
    cart: {
        get: function () {
            var ret = [];
            var itens = $('#cart-list').find('tr[name]');

            for (var i = 0; i < itens.length; ++i) {
                var item = $(itens[i]);

                var id = item.attr('name');
                var qtd = Number(item.find('td[name="qtd"]').text());
                ret.push({ 'id': id, 'qtd': qtd });
            }
            return ret;
        },
        add: function (cart, id, qtd, estoque, nome, c, t, v, va) {
            var e = cart.find('tr[name=' + id + ']');
            va = (va > 0 && va < v) ? va : v;

            if (e.length > 0) {
                var td_qtd = e.find('td[name="qtd"]');
                qtd += Number(td_qtd.text());
                if (qtd > estoque) { alert('Quantidade inválida!'); return; }
                if (qtd <= 0) e.remove();
                else {
                    td_qtd.text(qtd);
                }
            } else {
                if (qtd > estoque) { alert('Quantidade inválida!'); return; }
                cart.append('<tr name="' + id + '"><td>' + c + ' ' + t + ' ' + nome + '</td><td name="vu" data-vu="' + v + '" data-vau="' + va + '" >' +
                    '</td><td name="qtd" >' + qtd + '</td><td name="valor" ></td><td><i class="icon-remove cart-rem" ></i></td></tr>');
            }
            var upd = this.update.bind(this);
            upd();

            $('.cart-rem').click(function () {
                $(this).parent().parent().remove();
                upd();
            });
        },
        add_fn: function (id, c, t, estoque, produto) {
            var pt = $('#tbl-p');
            var cart = $('#cart-list');
            return (function () {
                var qtd = Number($('#tbl-p').find('input[name=' + id + ']').val());
                this.add(cart, id, qtd, estoque, produto.nome, c, t, produto.valor, produto.valorAtacado);
            }).bind(this);
        },
        update: function () {
            var total = 0;
            var total_a = 0;
            var cart = $('#cart-list');
            var t = $('#total');
			var t2 = $('#total_a');
            t.text('0.00');

            var rows = cart.find('tr[name]');
            var data = [];
            //calcula total e total atacado, salva valores
            for (var i = 0; i < rows.length; ++i) {
                var r = $(rows[i]);
                var qtd = Number(r.find('td[name="qtd"]').text());

                var td_vu = r.find('td[name="vu"]');
                var td_v = r.find('td[name="valor"]');

                var vu = Number(td_vu.data('vu'));
                var vau = Number(td_vu.data('vau'));
                var vt = vu * qtd;
                var vat = vau * qtd
                total += vt;
                total_a += vat;
                data.push({ '0': vu, '1': vau, '2': vt, '3': vat, 'vu': td_vu, 'v': td_v });
            }

            //atualiza dados do carrinho baseado no valor total
            var i1 = 0;
            var i2 = 2;
            var min_valor_atacado = sessionStorage.getItem('min_valor_atacado');
            if (total_a > min_valor_atacado && min_valor_atacado > 0) {
                i1 = 1;
                i2 = 3;
                t.text(Number(total_a).toFixed(2));
            } else
                t.text(Number(total).toFixed(2));

            for (var i = 0; i < data.length; ++i) {
                data[i].vu.text(Number(data[i][i1]).toFixed(2));
                data[i].v.text(Number(data[i][i2]).toFixed(2));
            }
			t2.text(Number(total_a).toFixed(2));
            this.juros.update();
        },
        getSubTotal: function () {
            return Number($('#total').text());
        },
        getTotal: function () {
            var tot = this.juros.getTotal(this.getSubTotal());
        },
        clear: function () {
            $('#cart-list tr[name]').remove();
            $('#total').text('0.00');
        },
        load: function (items) {
            this.clear();
            for (var i = 0; i < items.length; ++i) {
                this.add($('#cart-list'), items[i].id, items[i].qtd, items[i].qtd, items[i].nome, '', '', items[i].v1, items[i].v2);
            }
        },
        register: function (parent) {
            this.juros = parent.juros;
        }
    },
    comment: {
        add: function (text) {
            var b = text == undefined;
            text = b ? $('#obs-text').val() : text;
            if (b && text == '') { alert('Digite uma observação!'); return; }
            $('#obs-list').append('<li><span class="obs-item">' + text + '</span><span class="add-on btn obs-list-btn"><i class="icon-remove"></i></span></li>');
            $('.obs-list-btn').unbind('click').click(function () {
                $(this).parent().remove();
            });
        },
        clearText: function () {
            $('#obs-text').val('');
        },
        clear: function () {
            $('#obs-list').empty();
        },
        clearAll: function () {
            this.clear();
            this.clearText();
        },
        load: function (str) {
            if (str == undefined || str == '') return;
            var res = str.split(';');
            for (var i = 0; i < res.length; ++i)
                if (res[i] != '') this.add(res[i]);
        },
        getAll: function () {
            var obs = $('.obs-item');
            var text = '';
            for (var i = 0; i < obs.length; ++i) {
                text += $(obs[i]).text() + ';';
            }
            return text;
        },
        register: function () {
            $('#btn-add-obs').unbind().click(this.add.bind(undefined, undefined));
            $('#btn-rem-obs').unbind().click(this.clearText.bind(this));
        }
    },
    lock: function () {
        display($('#pedido-dado, #loading-box'));
        display($('#pedido-box'), false);
    },
    unlock: function () {
        display($('#pedido-dado, #loading-box'), false);
        display($('#pedido-box'));
    },
    display: function (data) {
        $('#pedido-cliente-nome').text(data.client.nome);
        $('#pedido-endereco').text(data.endereco.rua);
        $('#pedido-endereco-numero').text(data.endereco.numero);
        $('#pedido-bairro').text(data.endereco.bairro);
        $('#pedido-cidade').text(data.endereco.cidade);
        $('#pedido-estado').text(data.endereco.uf);
        $('#pedido-valor-frete').text(data.frete.valor);
        $('#pedido-tipo-frete').text(data.frete.nome);
        $('#pedido-frete-data').text(data.frete.prazo);
        $('#pedido-subtotal').text(Number(data.subtotal).toFixed(2));
        $('#pedido-total').text(Number(data.total).toFixed(2));

        var itens = data.itens;
        var tbl = $('.pedido-produto');

        tbl.find('tr').each(function () {
            var sel = $(this);
            var s2 = sel.find('th');
            var b = (s2.length == 0);
            if (s2.length == 0) {
                $(this).remove();
            }
        });
        for (var i = 0; i < itens.length; ++i) {
            tbl.append('<tr><td>' + itens[i].id + '</td><td>' + itens[i].nome + '</td><td>' + itens[i].qtd + '</td><td>' + Number(itens[i].vu).toFixed(2) + '</td><td>' + Number(itens[i].vt).toFixed(2) + '</td></tr>');
        }

        display($('#pedido-dado'));
    },
    clear: function () {
        $('#pedido-cliente-nome').text('');
        $('#pedido-endereco').text('');
        $('#pedido-endereco-numero').text('');
        $('#pedido-bairro').text('');
        $('#pedido-cidade').text('');
        $('#pedido-estado').text('');
        $('#pedido-valor-frete').text('');
        $('#pedido-tipo-frete').text('');
        $('#pedido-frete-data').text('');
        $('#pedido-subtotal').text('');
        $('#pedido-total').text('');
        var tbl = $('.pedido-produto');

        tbl.find('tr').each(function () {
            var sel = $(this);
            var s2 = sel.find('th');
            var b = (s2.length == 0);
            if (s2.length == 0) {
                $(this).remove();
            }
        });
       display($('#pedido-dado'), false);
    },
    finalize: function () {
        var cid = this.client.get();
        if (cid <= 0) { alert('Selecione um cliente!'); return; }

        var eid = this.client.address.get();
        if (eid <= 0) { alert('Selecione um endereço!'); return; }

        var frete = this.shipping.get();
        if (frete == null || frete < 0) { alert('Selecione o tipo de frete!'); return; }

        var itens = this.cart.get();
        if (itens.length <= 0) { alert('Adicione itens ao carrinho!'); return; }

        var juros = this.juros.get();
        if (juros == null || juros == '') {alert('Selecione o tipo de parcelamento!'); return;}

        var obs_text = this.comment.getAll();

        var phone = this.client.phone.get();

        var data = {
            'cid': cid, 'eid': eid, 'valor': this.cart.getSubTotal(), 'total': this.cart.getTotal(),
            'parcela': juros,'frete': frete, 'obs': obs_text, 'tel': phone, 'itens': itens
        };


        data = JSON.stringify(data);
        this.lock();
        var cb = function (data) {
            this.unlock();
            if (data.error != undefined)
                alert(data.error);
            else
                this.display(data);
        };
        request('save_pedido', { 'data': data }, cb.bind(this), this.unlock.bind(this));
    },
    confirmPayment: function () {
        var params = {};
        if (this.card.isEnabled()) {
            params = this.card.get();
            if (!this.card.validate(params)) {
                return;
            }
        }
        this.card.clear();

        this.lock();
        request('pay_pedido', params, (function (data) {
            this.unlock();
            if (data.error != undefined) {
                alert(data.error);
            } else {
                alert(data.msg);
                this.clearAll();
            }
        }).bind(this), this.unlock.bind(this));
    },
	confirmPayment2: function () {
        var params = {'emDinheiro' : true};
        this.lock();
        request('pay_pedido', params, (function (data) {
            this.unlock();
            if (data.error != undefined) {
                alert(data.error);
            } else {
                alert(data.msg);
                this.clearAll();
            }
        }).bind(this), this.unlock.bind(this));
    },
    clearAll: function () {
        this.client.clear();
        this.product.clear();
        this.shipping.clear();
        this.comment.clearAll();
        this.cart.clear();
        this.juros.clear();
        this.clear();
    },
    register: function () {
        this.client.register(this);
        this.product.register(this);
        this.shipping.register(this);
        this.comment.register(this);
        this.cart.register(this);
        this.juros.register(this);

        $('#btn-pedido-pay').unbind().click(this.confirmPayment.bind(this));
		$('#btn-pedido-pay2').unbind().click(this.confirmPayment2.bind(this));
        $('#btn-pedido-cancel').unbind().click(this.clear.bind(this));
        $('#finalizar').unbind().click(this.finalize.bind(this));
    },
    juros: {
        p:{},
        get: function () { return $('#list-parcel').val(); },
        getTotal: function (valor) {
            var val = this.p[this.get()];
            val = val == undefined || val == "" ? 0 : val;
            val = (100 + Number(val)) / 100;
            return valor * val;
        },
        update: function () {
            var total = Number($('#total').text());
            var val = this.getTotal(total);

            val != total ? $('#parcel-valor').show() : $('#parcel-valor').hide();
            $('#total-parcel').text(Number(val).toFixed(2));
            if (val > total) {
                $('#parcel-nome').text('Total parcelado');
            } else if (val < total) {
                $('#parcel-nome').text('Total com desconto');
            }
        },
        clear: function () {
            $('#parcel-valor').hide().text('');
            $('#list-parcel').val('');
        },
        register: function () {
            request('parcelamento', {}, (function (data) {
                //$('#list-parcel').append('<option value="0" >A vista</option>');
                this.p = {};
                this.p[0] = -Number(data.desconto);
                for (var i = 0; i < data.parcelas.length; ++i) {
                    var n = data.parcelas[i].n;
                    $('#list-parcel').append('<option value="'+n+'">' + n + 'X</option>')
                    this.p[n] = data.parcelas[i].value;
                }

                $('#list-parcel').change(this.update.bind(this)).change();

            }).bind(this));
        }
    },
    load: function (id) {
        this.lock();
        request('get_pedido', { 'id': id }, (function (pedido) {
            if (pedido.error != undefined) {
                alert('Não foi possível carregar o pedido!');
            } else {
                this.client.load(pedido.client.id, pedido.client.nome, pedido.endereco.id, pedido.telefone);
                this.shipping.load(pedido.frete.enum);
                this.cart.load(pedido.itens);
                this.comment.load(pedido.obs);
            }
            this.unlock();
        }).bind(this),
        (function () { this.unlock(); alert('Não foi possível carregar o pedido!'); }).bind(this));
    },
    card: {
        isEnabled: function () { return $('#card_number').length > 0; },
        get: function () {
            var cr = $('#card_holder').val();
            var cn = $('#card_number').val();
            var m = $('#card_mm').val();
            var y = $('#card_yy').val();
            var sc = $('#card_sc').val();
            return {'holder': cr, 'number':cn, 'code': sc, 'month': m, 'year': y};
        },
        validate: function (c) {
            if (c.holder == undefined || c.holder == "") { alert('Nome do proprietário inválido!'); return false; }
            if (!c.number.match(/^\d{16}$/)) { alert('Número do cartão inválido!'); return false; }
            if (!c.month.match(/^[01]\d$/)) { alert('Mês inválido!'); return false; }
            if (!c.year.match(/^\d\d$/)) { alert('Ano inválido!'); return false; }
            if (!c.code.match(/^\d\d\d$/)) { alert('Código de segurança inválido!'); return false; }
            return true;
        },
        clear: function () {
            $('#card_holder').val('');
            $('#card_number').val('');
            $('#card_mm').val('');
            $('#card_yy').val('');
            $('#card_sc').val('');
        }
    }
};

//order.register();
//order.load(18);
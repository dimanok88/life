var initialData = [];	
if(data) var initialData = data;
 
var ContactsModel = function(contacts) {
    var self = this;
    self.contacts = ko.observableArray(ko.utils.arrayMap(contacts, function(contact) {
        return { name: contact.name, description: contact.description, inter: ko.observableArray(contact.inter)};
    }));
    inter_id = ko.observable();

    self.addTest = function() {
        self.contacts.push({	   
            name: "",
            description: "",
            inter: ko.observableArray()
        });
    };
 
    self.removeTest = function(contact) {
        self.contacts.remove(contact);
    };
 
    self.addInter = function(contact) {
        contact.inter.push({
	    inter_id: "",
            min_width: "",
            max_width: "",
	    interpretation: "",
        });
    };
 
    self.removeInter = function(intr) {
        $.each(self.contacts(), function() { 
		if(!confirm('Вы уверены, что хотите удалить данный элемент?')) return false;
		this.inter.remove(intr) 
		$.post(deleteInter, {'inter':intr.inter_id}, function() {})		
	})

    };
    self.save = function() {
        s = JSON.stringify(ko.toJS(self.contacts), null, 2);
	$.post(link, {'s':s}, function(returnedData) {
	        self.lastSavedJson(returnedData);
		location.href = redirect;
	})
    };
 
    self.lastSavedJson = ko.observable("")
};
 
ko.applyBindings(new ContactsModel(initialData));

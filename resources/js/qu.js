var initialData = [];	
if(data) var initialData = data;
 
var ContactsModel = function(contacts) {
    var self = this;
    self.contacts = ko.observableArray(ko.utils.arrayMap(contacts, function(contact) {
        return { question_id: contact.question_id, q: contact.q, answers: ko.observableArray(contact.answers)};
    }));
    answer_id = ko.observable();

//Qestions
    self.addQuestion = function(contact) {
        self.contacts.push({
	    question_id: "",
            q: "",
	    answers: ko.observableArray([{q_id: "",
	    answer_id: "",            
	    ans: "",
	    point: "",},{q_id: "",
	    answer_id: "",            
	    ans: "",
	    point: "",},]),	    
        });
    };
 
    self.removeQuestion = function(q) { 
		if(!confirm('Вы уверены, что хотите удалить данный элемент?')) return false;
	        self.contacts.remove(q);
		$.post(deleteQuestion, {'q':q.question_id}, function() {})		

    };
 ///////////////////////////////////////
//Answers
    self.addAnswer = function(ans) {	
        ans.answers.push({
	    q_id: ans.question_id,
	    answer_id: "",            
	    ans: "",
	    point: "",
        });	
    };
 
    self.removeAnswer = function(answer) {       
		if(!confirm('Вы уверены, что хотите удалить данный элемент?')) return false;		
		$.each(self.contacts(), function() { 
			this.answers.remove(answer);			
		})		
		$.post(deleteAns, {'a':answer.answer_id}, function() {})

    }.bind(this);
////////////////////////////////

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

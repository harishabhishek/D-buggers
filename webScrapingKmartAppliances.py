from bs4 import BeautifulSoup
from urllib2 import urlopen
from time import sleep # be nice
 
BASE_URL = "http://www.kmart.com"
count=0
 
def make_soup(url):
    html = urlopen(url).read()
    return BeautifulSoup(html, 'html.parser')
 
def get_category_links(section_url):
    soup = make_soup(section_url)
    #boccat=soup.findAll('li',{'class':' gnf_nav_depth1_item gnf_dept_tree_item'})
    boccat = soup.findAll("li", " gnf_nav_depth3_item")
    file=open("newfile.txt", "a")
   
    category_links=[]
    for dd in boccat:
       temp= dd.find('a')
       if temp is not None:
        temp2=BASE_URL+dd.find('a')['href']
        file.write(temp2+'\n')
    with open('newfile.txt') as f:
       for line in f:
           category_links.append(line)
    return category_links
    
 
def get_products(category_url):
    global count
    soup = make_soup(category_url)
    file=open("data.txt", "a")
    #print soup
    boccat = soup.findAll("div", "cardProdTitle")
    for prod in boccat:
        temp=prod.find('a')
        if temp is not None:
            link=BASE_URL+prod.find('a')['href']
            title=prod.find('a')['title']
            count=count+1
            file.write(str(count)+ "\t"+ title.encode('utf8')+ "\t"+ link.encode('utf8')+ '\n')
            #file.write(link.encode('utf8') + '\n\n')
            #title2=encode(title)
            #link2=encode(link)
            #file.write(title2+ "\n")
            #file.write(link2+"\n\n")
   
 
if __name__ == '__main__':
    section = ("http://www.kmart.com/appliances/b-20002")
	
   
    
    categories = get_category_links(section)
    for category in categories:
        sub_category_links=get_category_links(category)
        for sub in sub_category_links:
            sub2_cat=get_category_links(sub)
            for sub2 in sub2_cat:
                #print sub2
                get_products(sub2)
                sleep(1)
   

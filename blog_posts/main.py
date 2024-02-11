from requests_html import HTMLSession
from bs4 import BeautifulSoup
import requests
import time
import json
import re
import random

def random_numbers():
    return random.sample(range(1, 101), 5)

def shorten_url( long_url):
    api_endpoint = "https://adfoc.us/api/"
    api_url = f"{api_endpoint}?key=71328f081157ba9b07dd22229a27585f&url={long_url}"
    response = requests.get(api_url)
    if response.status_code == 200:
        second_url = response.text.strip()
        return second_url

def extract_blog(url,id):
    try:
        # Make a GET request to the URL
        response = requests.get(url)
        
        # Check if the request was successful (status code 200)
        if response.status_code == 200:
            soup = BeautifulSoup(response.text, 'html.parser')

            # Find all ul elements with the specified class 'page__list'
            data_list = soup.find('ul', class_='page__list')

            # Iterate over each ul element
            if data_list:
                # Extract and print all Developer names and their values
                developer_infos = data_list.find_all(lambda tag: tag.name == 'li' and 'Developer:' in tag.text)
                for developer_info in developer_infos:
                    developer_name = developer_info.find_all('span')
                    if len(developer_name) == 2:
                        # Extract the developer name and print
                        developer_name = developer_name[1].text.strip()
                        #print(f"Developer: {developer_name}")
            if data_list:
                # Extract and print all Developer names and their values
                time_infos = data_list.find_all(lambda tag: tag.name == 'li' and 'Updated:' in tag.text)
                for time_info in time_infos:
                    time_name = time_info.find_all('span')
                    if len(time_name) == 2:
                        # Extract the developer name and print
                        time_name = time_name[1].text.strip()
                        #print(f"Time: {time_name}")
                        
            if data_list:
                # Extract and print all Developer names and their values
                version_infos = data_list.find_all(lambda tag: tag.name == 'li' and 'Current version:' in tag.text)
                for version_info in version_infos:
                    version_name = version_info.find_all('span')
                    if len(version_name) == 2:
                        # Extract the developer name and print
                        version_name = version_name[1].text.strip()
                        #print(f"Version: {version_name}")
                        
            if data_list:
                # Extract and print all Developer names and their values
                statue_infos = data_list.find('div',id='wid_m_cat')
                if statue_infos:#wid_m_catw
                    statue = statue_infos.text.strip()
                    if statue == 'UNDETECTED' :
                        statue = "Live"
                else :
                        statue = "Down"
            
            print("Blogs information done extracting....")
                    
        data = {"text":[]}
        
        if response.status_code == 200:
            soup = BeautifulSoup(response.text, 'html.parser')
            Text = soup.find('div',class_='cover')
            Text_part = Text.find_all('p')
            for text_info in Text_part:
                text_ = text_info.text.strip()
                
                data["text"].append(text_)
                
            formatted_text = '\n'.join(data["text"])
            
            print('Text done extracting..')
        
        if response.status_code == 200:
            soup = BeautifulSoup(response.text, 'html.parser')
            link_ = soup.find('input', {'id': 'myInput'})
            if link_:
                link = link_.get('value')
                print(f'link_inshorted:{link}')
                if link[0:5] == "https":
                    link_2 = shorten_url(link)
                    print(f'link ={link_2} ')
                else :
                    link_2 = link

            print('Link done extracting..')
                
        # Check if the request was successful (status code 200)
        if response.status_code == 200:
            soup = BeautifulSoup(response.text, 'html.parser')
            div  = soup.find('div',class_='cover')
            image_ = div.find('img')
            if image_:
                image = image_.get('data-src')
                link_img = f'https://cheater.fun{image}'
            
            print('Images done extracting..')

        
        # Check if the request was successful (status code 200)
        if response.status_code == 200:
            soup = BeautifulSoup(response.text, 'html.parser')
            div = soup.find('span', class_='d_none_mb me-4')
            tag = div.text.strip()
            print('Tags done extracting..')
            
        #fw-bold mt-2
        if response.status_code == 200:
            soup = BeautifulSoup(response.text, 'html.parser')
            div = soup.find('h1', class_='fw-bold mt-2')
            title = div.text.strip()
            
        #id = random.randint(10000, 99999)
        print("Id generated ...")
        
        print('Done')
        print('___________________________________________________________________________')
            
        return {"id":id,"title":title,"text": formatted_text, "tags": tag, "image": link_img, "creator": developer_name,"link":link_2,"time":time_name,"status":statue,"version":version_name}
           
    except Exception as e:
        print(f"Error: {e}")
        print('___________________________________________________________________________')
        return None         
    
number = int(input("How many page you Want to Extract:"))
x = 1
for i in range(3,number):
    url = f'https://cheater.fun/page/{i}/'
    response = requests.get(url)
    time.sleep(2)
    if response:
        soup = BeautifulSoup(response.text, 'html.parser')

        # Find all div elements with the specified ID 'wid_m_right'
        divs_wid_m_right = soup.find_all('div', id='wid_m_right')

        # Check if any divs with ID 'wid_m_right' are found
        if divs_wid_m_right:
            for div_wid_m_right in divs_wid_m_right:
                # Find all 'a' tags within the div
                links = div_wid_m_right.find_all('a')

                # Extract and print the links and titles
                for link in links:

                    title = link.find('h2').text.strip()
                    print(f'{x}_Title:{title}')
                    print("Extraction ...")
                    url = link['href'].strip()
                    id = 1000 + x
                    result = extract_blog(url,id)
                    cleaned_title = re.sub(r'[ :;,\-_]+', '_', title)
                    output_file = f'{cleaned_title}.json'
                    with open(output_file, 'w', encoding='utf-8') as json_file:
                        json.dump(result, json_file, ensure_ascii=False, indent=2)
                    print('Sleeping ......')
                    time.sleep(2)

                    #print(f"{x}_Title: {title}\nLink: {url}\n")
                    x += 1
        else:
            print("error")
                
    

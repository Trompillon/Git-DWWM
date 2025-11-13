from bs4 import BeautifulSoup
import json
import re

# Chemin vers ton fichier Twine
chemin_fichier = "/home/sebastien/Téléchargements/le_donjon_du_magicien_fou.html"

# Lire le fichier HTML
with open(chemin_fichier, "r", encoding="utf-8") as f:
    html = f.read()

soup = BeautifulSoup(html, "html.parser")

passages = []

for passage in soup.find_all("tw-passagedata"):
    nom = passage.get("name")
    texte = passage.text.strip()
    
    # Récupérer les choix sous forme [[Texte->NomDuPassage]]
    choix = []
    for match in re.findall(r"\[\[(.*?)\]\]", texte):
        if "->" in match:
            texte_choix, next_passage = match.split("->", 1)
            choix.append({"texte": texte_choix.strip(), "next": next_passage.strip()})
        else:
            # Cas où il n'y a pas de flèche, le choix pointe vers le même texte
            choix.append({"texte": match.strip(), "next": match.strip()})
    
    passages.append({
        "name": nom,
        "text": texte,
        "choices": choix
    })

# Sauvegarder en JSON
chemin_json = "/home/sebastien/Téléchargements/passages.json"
with open(chemin_json, "w", encoding="utf-8") as f:
    json.dump(passages, f, ensure_ascii=False, indent=2)

print(f"{len(passages)} passages extraits et sauvegardés dans {chemin_json}")

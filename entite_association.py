import matplotlib.pyplot as plt
import matplotlib.patches as patches

# Create a figure and a set of subplots
fig, ax = plt.subplots(figsize=(15, 10))

# Define the properties for the text boxes
bbox_props = dict(boxstyle="round,pad=0.3", edgecolor="black", facecolor="lightgray", linewidth=2)

# Define the text for each entity
entities = {
    "Client": [
        "id (PK)",
        "Nom",
        "Prénom",
        "courriel",
        "Mot_de_passe",
        "Adresse_Ligne_1",
        "Adresse_Ligne_2",
        "Ville",
        "Code_Postal",
        "Pays",
        "Numéro_de_téléphone",
        "Type_de_carte_de_paiement",
        "Numéro_de_la_carte",
        "Nom_sur_la_carte",
        "Date_d_expiration_de_la_carte",
        "Code_de_sécurité"
    ],
    "Agent_Immo": [
        "numero_identification (PK)",
        "mot_de_passe",
        "nom",
        "prenom",
        "specialite",
        "disponibilites",
        "video",
        "photo",
        "cv",
        "tel",
        "bureau",
        "courriel",
        "honoraire"
    ],
    "Bien": [
        "numero (PK)",
        "type",
        "photo",
        "description",
        "adresse",
        "id_agent (FK)"
    ],
    "Consultation": [
        "id (PK)",
        "id_client (FK)",
        "date",
        "heure",
        "id_agent (FK)"
    ],
    "RDV": [
        "id (PK)",
        "id_agent (FK)",
        "id_client (FK)",
        "date",
        "heure",
        "adresse",
        "digicode",
        "autres_informations"
    ],
    "Paiement": [
        "id (PK)",
        "id_client (FK)",
        "num_carte",
        "prenom_carte",
        "nom_carte",
        "adresse_L1",
        "adresse_L2",
        "ville",
        "code_postal",
        "pays",
        "numero"
    ],
    "Administrateur": [
        "id (PK)",
        "nom",
        "prenom",
        "courriel",
        "mot_de_passe"
    ]
}

# Define the positions for each entity
positions = {
    "Client": (0.1, 0.8),
    "Agent_Immo": (0.7, 0.8),
    "Bien": (0.1, 0.5),
    "Consultation": (0.4, 0.5),
    "RDV": (0.7, 0.5),
    "Paiement": (0.1, 0.2),
    "Administrateur": (0.7, 0.2)
}

# Draw each entity with its attributes
for entity, pos in positions.items():
    ax.text(pos[0], pos[1], f"{entity}\n" + "\n".join(entities[entity]), 
            transform=ax.transAxes, 
            bbox=bbox_props, 
            fontsize=12, 
            ha="center")

# Define the relationships between entities
relationships = [
    ("Client", "Consultation", "1,N"),
    ("Agent_Immo", "Consultation", "1,N"),
    ("Agent_Immo", "RDV", "1,N"),
    ("Client", "RDV", "1,N"),
    ("Agent_Immo", "Bien", "1,N"),
    ("Client", "Paiement", "1,N")
]

# Draw the relationships
for rel in relationships:
    start_pos = positions[rel[0]]
    end_pos = positions[rel[1]]
    ax.annotate("",
                xy=end_pos, xycoords="axes fraction",
                xytext=start_pos, textcoords="axes fraction",
                arrowprops=dict(arrowstyle="->", lw=1.5),
                annotation_clip=False)
    mid_pos = ((start_pos[0] + end_pos[0]) / 2, (start_pos[1] + end_pos[1]) / 2)
    ax.text(mid_pos[0], mid_pos[1], rel[2], transform=ax.transAxes, fontsize=12, ha="center")

# Set the axis limits and remove the axis
ax.set_xlim(0, 1)
ax.set_ylim(0, 1)
ax.axis('off')

# Save the figure
plt.savefig("Modele_Entite_Association.png", format='png')

# Display the plot
plt.show()

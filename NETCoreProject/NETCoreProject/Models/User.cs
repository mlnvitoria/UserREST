using System;
using System.ComponentModel.DataAnnotations;

namespace NETCoreProject.Models
{
    public class User : IEntity
    {
        [Required]
        public int Id { get; set; }

        [Required]
        [StringLength(100, MinimumLength = 2)]
        public string FirstName { get; set; }

        [Required]
        [StringLength(100, MinimumLength = 2)]
        public string LastName { get; set; }

        [Required]
        [StringLength(100, MinimumLength = 2)]
        [EmailAddress()]
        public string Email { get; set; }

        public string ApiToken { get; set; }

        [DataType(DataType.Date)]
        public DateTime? CreatedAt { get; set; }

        [DataType(DataType.Date)]
        public DateTime? UpdatedAt { get; set; }

        [DataType(DataType.Date)]
        public DateTime? DeletedAt { get; set; }

    }
}
